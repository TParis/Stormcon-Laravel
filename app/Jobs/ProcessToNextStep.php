<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Workflow;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Filesystem\Exception\IOException;

class ProcessToNextStep implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $drive;
    private $project;
    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Workflow $workflow)
    {
        $this->drive = $user->getOneDrive();
        $this->project = $workflow->project;
        $this->user = $workflow->step()->assigned;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $origin = "/Personal/" . $this->user->fullName . "/" . $this->project->id . " - " . $this->project->name;

        $template_items = collect($this->drive->listContents($origin, true));

        foreach ($template_items as $item) {

            //Explode existing path
            $path_array = explode("/", $item["path"]);

            //Adjust the path
            array_shift($path_array);
            array_shift($path_array);
            array_shift($path_array);
            array_unshift($path_array, $this->project->id . " - " . $this->project->name);
            array_unshift($path_array, "Projects");

            //Maintain string as I drop down the path
            $path_string = "";

            //Make sure all of the folders exist.
            $count = ($item["type"] == "file") ? count($path_array) - 1 : count($path_array);
            for ($i = 0; $i < $count; $i++) {
                $path_string = $path_string . "/" . $path_array[$i];
                print($path_string . "\r\n");
                if (!$this->drive->has($path_string)) $this->drive->createDir($path_string);
            }

            //Copy the item
            if ($item["type"] == "file") {
                print("Testing for existence of: " . "/" . implode("/", $path_array));
                if ($this->drive->has("/" . implode("/", $path_array))) {
                    print("Deleting: " . "/" . implode("/", $path_array));
                    $this->drive->delete("/" . implode("/", $path_array));
                }
                if (!$this->drive->copy($item["path"], "/" . implode("/", $path_array))) {
                    throw new IOException("Could not copy " . $item["path"] . " to projects directory.");
                }
            }
        }

        $this->drive->deleteDir($origin);
    }
}
