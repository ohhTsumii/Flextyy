<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;

    // If the table name doesn't follow Laravel's pluralization rules
     protected $table = 'inspections';

    // Define the fillable properties for mass assignment
    protected $fillable = [
        'weeknumber', 'country', 'recycleplant', 'inspector',
        'glassfactory', 'testtype', 'cullettype', 'quantity'
    ];

    /**
     * Insert a new inspection record.
     *
     * @param array $data
     * @return Inspection
     */
    public static function createInspection(array $data): Inspection
    {
        // Using mass assignment
        return self::create([
            'weeknumber' => $data['weekNumber'],
            'country' => $data['country'],
            'recycleplant' => $data['recyclePlant'],
            'inspector' => $data['inspector'],
            'glassfactory' => $data['glassFactory'],
            'testtype' => $data['testType'],
            'cullettype' => $data['culletType'],
            'quantity' => $data['quantity'],
        ]);
    }

    /**
     * Update an existing inspection record by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public static function updateInspection(int $id, array $data): bool
    {
        // Find the inspection by ID and update
        $inspection = self::find($id);

        if ($inspection) {
            return $inspection->update([
                'weeknumber' => $data['weekNumber'],
                'country' => $data['country'],
                'recycleplant' => $data['recyclePlant'],
                'inspector' => $data['inspector'],
                'glassfactory' => $data['glassFactory'],
                'testtype' => $data['testType'],
                'cullettype' => $data['culletType'],
                'quantity' => $data['quantity'],
            ]);
        }

        return false; // Return false if the inspection was not found
    }

    /**
     * Delete an inspection by ID.
     *
     * @param int $id
     * @return bool|null
     */
    public static function deleteInspection(int $id): ?bool
    {
        // Find the inspection by ID and delete
        $inspection = self::find($id);

        if ($inspection) {
            return $inspection->delete();
        }

        return false; // Return false if the inspection was not found
    }

}
