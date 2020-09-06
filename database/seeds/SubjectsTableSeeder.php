<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Subject;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->delete();

        $subjects = [
            'Wohnung',
            'Auto',
            'Lebensmittel',
            'Getränke',
            'Restaurant',
            'Versicherung',
            'Kommunikation',
            'Hobby',
            'Abos',
            'Kontoführung',
            'Urlaub',
            'Sport',
            'Altersvorsorge',
            'Medikamente',
            'Sonstige Ausgaben',
            'Sonstige Einnahme',
            'Lohn / Gehalt'
        ];

        foreach ( $subjects as $subject ) {
            Subject::create([
                'user_id' => 1,
                'is_global' => 1,
                'name' => $subject
            ]);
        }
    }
}
