<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Models\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of departments.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Department::class);

        $query = Department::whereNull('deleted_at');

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $query->latest('id'); // newest first

        $perPage = in_array($request->input('per_page'), [10, 20, 50, 100])
            ? $request->input('per_page')
            : 20;

        $departments = $query->paginate($perPage)->appends($request->query());

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        $this->authorize('create', Department::class);

        return view('departments.create');
    }

    /**
     * Store a newly created department in storage.
     */
    public function store(DepartmentStoreRequest $request)
    {
        $this->authorize('create', Department::class);

        $validated = $request->validated();

        // Note: created and modified are auto-set by Department model boot method
        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully / 部署を登録しました。');
    }

    /**
     * Show the form for editing the specified department.
     */
    public function edit(Department $department)
    {
        $this->authorize('update', $department);

        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified department in storage.
     */
    public function update(DepartmentUpdateRequest $request, Department $department)
    {
        $this->authorize('update', $department);

        $validated = $request->validated();

        // Note: modified is auto-set by Department model boot method
        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully / 部署を更新しました。');
    }

    /**
     * Remove the specified department from storage.
     */
    public function destroy(Department $department)
    {
        $this->authorize('delete', $department);

        // Note: deleted is auto-set by Department model boot method
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully / 部署を削除しました。');
    }
}
