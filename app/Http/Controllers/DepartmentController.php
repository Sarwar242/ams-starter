<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments.
     */
    public function index(Request $request): Response
    {
        // $this->authorize('viewAny', Department::class);

        $query = Department::query()
        ->with(['creator:id,name', 'modifier:id,name'])
        ->withCount('users');

        // Search filtering
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Default sort: latest first
        $query->orderBy('id', 'desc');

        // Per page - allowed values
        $perPage = $request->input('per_page', 20); // default 20
        $allowed = [10, 20, 50, 100];
        $perPage = in_array($perPage, $allowed) ? $perPage : 20;

        $departments = $query->paginate($perPage);

        // Keep filters in pagination links
        $departments->appends([
            'search' => $request->input('search'),
            'per_page' => $perPage,
        ]);

        return Inertia::render('Departments/Index', [
            'departments' => $departments,
            'filters' => [
                'search' => $request->input('search', ''),
                'per_page' => $perPage,
            ],
            'flash' => [
                'success' => session('success'),
            ],
        ]);
    }

    /**
     * Show the form for creating a new department.
     */
    public function create(): Response
    {
        // $this->authorize('create', Department::class);

        return Inertia::render('Departments/Create');
    }

    /**
     * Store a newly created department in storage.
     */
    public function store(DepartmentStoreRequest $request): RedirectResponse
    {

        Department::create($request->validated());

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully / 部門を登録しました。');
    }

    /**
     * Show the form for editing the specified department.
     */
    public function edit(Department $department): Response
    {

        // Load creator and modifier without their department relationship to avoid circular loading
        $department->load([
            'creator' => function ($query) {
                $query->select('id', 'name')->without('department');
            },
            'modifier' => function ($query) {
                $query->select('id', 'name')->without('department');
            }
        ]);

        return Inertia::render('Departments/Edit', [
            'department' => $department,
        ]);
    }

    /**
     * Update the specified department in storage.
     */
    public function update(DepartmentUpdateRequest $request, Department $department): RedirectResponse
    {

        $department->update($request->validated());

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully / 部門を更新しました。');
    }

    /**
     * Remove the specified department from storage (soft delete).
     */
    public function destroy(Department $department): RedirectResponse
    {
        $this->authorize('delete', $department);

        // Check if department has users
        if ($department->users()->count() > 0) {
            return redirect()->route('departments.index')
                ->with('error', 'Cannot delete department with assigned employees. Please reassign employees first / 従業員が割り当てられている部門は削除できません。');
        }

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully / 部門を削除しました。');
    }
}
