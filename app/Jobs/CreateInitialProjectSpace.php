<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Project;
use App\Models\WorkflowTemplate;

class CreateInitialProjectSpace implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $project;
    protected $template;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Project $project, WorkflowTemplate $template)
    {
        $this->project = $project;
        $this->template = $template;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $drive = $this->user->getOneDrive();

        $template_items = collect($drive->listContents('/Templates/' . $this->template->template, true));

        //Does the projects directory exist?
        if (!$drive->has("/Projects")) $drive->createDir("Projects");
        if (!$drive->has("/Projects/" . $this->project->id . " - " . $this->project->name))
            $drive->createDir("Projects/" . $this->project->id . " - " . $this->project->name);

        foreach ($template_items as $item) {

            //Explode existing path
            $path_array = explode("/", $item["path"]);

            //Adjust the path
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
                if (!$drive->has($path_string)) $drive->createDir($path_string);
            }

            //Copy the item
            if ($item["type"] == "file")
                $drive->copy($item["path"], "/" . implode("/", $path_array));
        }
    }
}
