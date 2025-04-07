<?php

namespace App\Http\Controllers;

use App\Models\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportAllUsers(Request $request)
    {
       
        $users = User::with('profile')->get();
        $data = [
            ['Name', 'Email', 'Phone', 'Address', 'Bio'], 
        ];
        foreach ($users as $user) {
            $data[] = [
                $user->name,
                $user->email, 
                $user->profile->phone ?? 'N/A', 
                $user->profile->address ?? 'N/A',
                $user->profile->bio ?? 'N/A', 
            ];
        }

        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->fromArray($data, NULL, 'A1');
             $filePath = storage_path('app/public/users.xlsx');

            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);
            return response()->download($filePath, 'users.xlsx')->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'There was an error generating the file.',
                'message' => $e->getMessage(),
                'file' => 'users.xlsx',
            ], 500);
        }
    }

    public function exportUser($id)
    {
        $user = User::with('profile')->find($id);

       
        if (!$user) {
            return response()->json([
                'error' => 'User not found!',
                'user_id' => $id
            ], 404);
        }

       
        $data = [
            ['Name', 'Email', 'Phone', 'Address', 'Bio'], 
            [
                $user->name,
                $user->email, 
                $user->profile->phone ?? 'N/A', 
                $user->profile->address ?? 'N/A', 
                $user->profile->bio ?? 'N/A', 
            ]
        ];

        try {
           
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray($data, NULL, 'A1');
            $filePath = storage_path("app/public/user_{$id}.xlsx");
            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);
            return response()->download($filePath, "user_{$id}.xlsx")->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'There was an error generating the file.',
                'message' => $e->getMessage(),
                'file' => "user_{$id}.xlsx",
            ], 500);
        }
    }
}


