<?php

namespace App\Http\Controllers;

use App\Models\BusinessPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessPartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = BusinessPartner::whereNull('deleted_at');

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $query->latest('id'); // newest first

        $perPage = in_array($request->input('per_page'), [10, 20, 50, 100])
            ? $request->input('per_page')
            : 20;

        $partners = $query->paginate($perPage)->appends($request->query());

        return view('business-partners.index', compact('partners'));
    }

    public function create()
    {
        return view('business-partners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'nullable',
                'string',
                'max:50',
                'unique:business_partners,code,NULL,id,deleted_at,NULL',
            ],
            'is_subcontractor' => 'required|in:0,1',
            'contact_person' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20|regex:/^[\d\+\-\s\(\)]+$/',
            'email' => 'nullable|email|max:100',
        ]);

        // Set default false if not sent
$validated['is_subcontractor'] = $request->boolean('is_subcontractor', false); // ← important line

        $validated['created'] = Auth::id();

        BusinessPartner::create($validated);

        return redirect()->route('business-partners.index')
            ->with('success', 'Partner created successfully / 取引先を登録しました。');
    }

    public function edit(BusinessPartner $businessPartner)
    {
        return view('business-partners.edit', compact('businessPartner'));
    }

    public function update(Request $request, BusinessPartner $businessPartner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'nullable',
                'string',
                'max:50',
                'unique:business_partners,code,' . $businessPartner->id . ',id,deleted_at,NULL',
            ],
            'is_subcontractor' => 'required|in:0,1',
            'contact_person' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20|regex:/^[\d\+\-\s\(\)]+$/',
            'email' => 'nullable|email|max:100',
        ]);
        // Set default false if not sent
        $validated['is_subcontractor'] = $request->boolean('is_subcontractor', false); // ← important line
        $validated['modified'] = Auth::id();

        $businessPartner->update($validated);

        return redirect()->route('business-partners.index')
            ->with('success', 'Partner updated successfully / 取引先を更新しました。');
    }

    public function destroy(BusinessPartner $businessPartner)
    {
        $businessPartner->deleted = Auth::id();
        $businessPartner->delete();

        return redirect()->route('business-partners.index')
            ->with('success', 'Partner deleted successfully / 取引先を削除しました。');
    }
}