<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Device;
use App\Models\Model;
use App\Models\Problem;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TreeExplorerSampleSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $device = Device::updateOrCreate(
                ['name' => 'Sample Diagnostic Device'],
                ['name' => 'Sample Diagnostic Device']
            );

            $brand = Brand::updateOrCreate(
                ['name' => 'Sample Brand X', 'device_id' => $device->id],
                ['name' => 'Sample Brand X', 'device_id' => $device->id]
            );

            $model = Model::updateOrCreate(
                ['name' => 'Sample Model Z', 'brand_id' => $brand->id],
                ['name' => 'Sample Model Z', 'brand_id' => $brand->id]
            );

            $powerProblem = Problem::updateOrCreate(
                ['name' => 'Sample: Device Not Powering On', 'model_id' => $model->id],
                ['name' => 'Sample: Device Not Powering On', 'model_id' => $model->id]
            );

            $displayProblem = Problem::updateOrCreate(
                ['name' => 'Sample: Blank Display', 'model_id' => $model->id],
                ['name' => 'Sample: Blank Display', 'model_id' => $model->id]
            );

            $networkProblem = Problem::updateOrCreate(
                ['name' => 'Sample: No Network Signal', 'model_id' => $model->id],
                ['name' => 'Sample: No Network Signal', 'model_id' => $model->id]
            );

            $this->seedPowerFlow($powerProblem->id);
            $this->seedDisplayFlow($displayProblem->id);
            $this->seedNetworkFlow($networkProblem->id);
        });
    }

    private function seedPowerFlow(int $problemId): void
    {
        $q1 = $this->upsertQuestion($problemId, 'Does the device show any LED indication when pressing power?', 'Check front LED behavior while power key is pressed for 5 seconds.');
        $q2 = $this->upsertQuestion($problemId, 'Is the battery voltage above the minimum threshold?', 'Measure battery line with multimeter. Threshold: >3.6V.');
        $q3 = $this->upsertQuestion($problemId, 'Try known-good charger. Does charging current appear?', 'Connect a verified charger and check current draw.');
        $q4 = $this->upsertQuestion($problemId, 'Does the power button flex/cable pass continuity test?', 'Inspect and test power key line continuity.');
        $q5 = $this->upsertQuestion($problemId, 'Replace battery and retest power on.', 'Use compatible battery module and attempt boot.');
        $q6 = $this->upsertQuestion($problemId, 'Inspect PMIC input rail for short to ground.', 'Check resistance to ground on PMIC VIN line.');
        $q7 = $this->upsertQuestion($problemId, 'Escalate to board-level repair.', 'Likely PMIC or logic board issue requiring micro-soldering.');

        $this->link($q1, $q2, $q3);
        $this->link($q2, $q4, $q5);
        $this->link($q3, $q5, $q6);
        $this->link($q4, null, $q7);
        $this->link($q5, null, $q7);
        $this->link($q6, null, $q7);
    }

    private function seedDisplayFlow(int $problemId): void
    {
        $q1 = $this->upsertQuestion($problemId, 'Is backlight visible on the panel?', 'Observe in dark environment to detect faint glow.');
        $q2 = $this->upsertQuestion($problemId, 'Is display connector properly seated?', 'Reseat LCD/eDP connector and inspect pin damage.');
        $q3 = $this->upsertQuestion($problemId, 'Does external display output work?', 'Connect HDMI/DP monitor and verify video output.');
        $q4 = $this->upsertQuestion($problemId, 'Replace panel and retest.', 'Use known-good panel for this model.');
        $q5 = $this->upsertQuestion($problemId, 'Inspect display power rail and fuse.', 'Check LCD power fuse continuity and voltage.');
        $q6 = $this->upsertQuestion($problemId, 'Escalate to GPU/board diagnosis.', 'Video output path issue on motherboard.');

        $this->link($q1, $q2, $q3);
        $this->link($q2, null, $q4);
        $this->link($q3, $q4, $q5);
        $this->link($q5, null, $q6);
    }

    private function seedNetworkFlow(int $problemId): void
    {
        $q1 = $this->upsertQuestion($problemId, 'Does SIM card detect in device settings?', 'Open SIM status and verify operator + ICCID visibility.');
        $q2 = $this->upsertQuestion($problemId, 'Is airplane mode disabled?', 'Toggle airplane mode OFF and retry registration.');
        $q3 = $this->upsertQuestion($problemId, 'Try known-good SIM from same network.', 'Rule out SIM provisioning or damage.');
        $q4 = $this->upsertQuestion($problemId, 'Reset network settings and re-scan.', 'Reset APN + network stack settings.');
        $q5 = $this->upsertQuestion($problemId, 'Inspect antenna connector and RF cable.', 'Check loose/disconnected antenna line.');
        $q6 = $this->upsertQuestion($problemId, 'Escalate to baseband/RF hardware repair.', 'Potential RF front-end or baseband fault.');

        $this->link($q1, $q2, $q3);
        $this->link($q2, $q3, $q4);
        $this->link($q3, $q4, $q5);
        $this->link($q5, null, $q6);
    }

    private function upsertQuestion(int $problemId, string $text, ?string $description = null): Question
    {
        return Question::updateOrCreate(
            [
                'problem_id' => $problemId,
                'question_text' => $text,
            ],
            [
                'description' => $description,
            ]
        );
    }

    private function link(Question $question, ?Question $yes, ?Question $no): void
    {
        $question->yes_question_id = $yes?->id;
        $question->no_question_id = $no?->id;
        $question->save();
    }
}
