<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $table = 'results';

    protected $fillable = [
        'weeknumber',
        'country',
        'recycleplant',
        'inspector',
        'glassfactory',
        'testtype',
        'cullettype',
        'quantity',
        'date',
        'lotSize',
        'inspection',
        'contamination',
        'humidity',
        'ceramic_pc',
        'stones_pc',
        'porcelain_pc',
        'ceramic_gr',
        'stones_gr',
        'porcelain_gr',
        'opalGlass',
        'magnetic',
        'nonMagnetic',
        'organicMatter',
        'plasticSeperate',
        'pyroGlass_gr',
        'pyroGlass_pc',
        'largerThan70mm',
        'largerThan10mm',
        'between5mmAnd10mm',
        'smallerThan5mm',
        'flint',
        'green',
        'amber',
        'deadLeaf',
        'blue',
    ];

    /**
     * Insert a new inspection record.
     *
     * @param array $data
     * @return false
     */

    public static function createResult(array $data): bool
    {
        // Check for an existing record
        $existingRecord = self::where('inspection', $data['id'])
            ->first();

        // If the record exists, return it or handle the situation
        if ($existingRecord) {
            return false;
        }

        // Using mass assignment
        $result = self::create([
            'lotSize' => $data['lotSize'] ?? 0,
            'inspection' => $data['id'] ?? 0,
            'contamination' => $data['contamination'] ?? 0,
            'humidity' => $data['humidity'] ?? 0,
            'ceramic_pc' => $data['ceramic_pc'] ?? 0,
            'stones_pc' => $data['stones_pc'] ?? 0,
            'porcelain_pc' => $data['porcelain_pc'] ?? 0,
            'ceramic_gr' => $data['ceramic_gr'] ?? 0,
            'stones_gr' => $data['stones_gr'] ?? 0,
            'porcelain_gr' => $data['porcelain_gr'] ?? 0,
            'opalGlass' => $data['opalGlass'] ?? 0,
            'magnetic' => $data['magnetic'] ?? 0,
            'nonMagnetic' => $data['nonMagnetic'] ?? 0,
            'organicMatter' => $data['organicMatter'] ?? 0,
            'plasticSeperate' => $data['plasticSeperate'] ?? 0,
            'pyroGlass_gr' => $data['pyroGlass_gr'] ?? 0,
            'pyroGlass_pc' => $data['pyroGlass_pc'] ?? 0,
            'largerThan70mm' => $data['largerThan70mm'] ?? 0,
            'largerThan10mm' => $data['largerThan10mm'] ?? 0,
            'between5mmAnd10mm' => $data['between5mmAnd10mm'] ?? 0,
            'smallerThan5mm' => $data['smallerThan5mm'] ?? 0,
            'flint' => $data['flint'] ?? 0,
            'green' => $data['green'] ?? 0,
            'amber' => $data['amber'] ?? 0,
            'deadLeaf' => $data['deadLeaf'] ?? 0,
            'blue' => $data['blue'] ?? 0,
        ]);
        return $result !== null;
    }
}
