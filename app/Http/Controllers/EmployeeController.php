<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::withCount('assets');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        $employees = $query->latest()->paginate(10);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:20|unique:employees,nip',
            'nik' => 'nullable|string|max:20|unique:employees,nik',
            'email' => 'nullable|email|max:255|unique:employees,email',
            'alamat' => 'nullable|string|max:255',
            'position' => 'required|string',
            'department' => 'required|string',
        ]);

        Employee::create($request->all());

        return redirect()->route('employees.index')
            ->with('success', 'Data pegawai berhasil ditambahkan.');
    }


    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }


    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:20|unique:employees,nip,' . $employee->id,
            'nik' => 'nullable|string|max:20|unique:employees,nik,' . $employee->id,
            'email' => 'nullable|email|max:255|unique:employees,email,' . $employee->id,
            'alamat' => 'nullable|string|max:255',
            'position' => 'required|string',
            'department' => 'required|string',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')
            ->with('success', 'Data pegawai diperbarui.');
    }


    public function destroy(Employee $employee)
    {
        if ($employee->assets()->count() > 0) {
            return back()->withErrors([
                'Gagal: Pegawai ini masih memegang aset. Harap lakukan mutasi aset terlebih dahulu.'
            ]);
        }

        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Data pegawai dihapus.');
    }
}