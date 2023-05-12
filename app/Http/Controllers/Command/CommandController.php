<?php

namespace App\Http\Controllers\Command;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class CommandController extends Controller
{
    public function updateCode()
    {
        $cmd = "cd /www/wwwroot/caplaravel.com/ && svn update";
        $process = Process::fromShellCommandline($cmd);
        $processOutput = '';
        $captureOutput = function($type, $line) use (&$processOutput) {
            $processOutput .= $line;
        };

        $process->setTimeout(null)->run($captureOutput);

        if ($process->getExitCode()){
            return 'Failed: '. $process->getExitCodeText();
        }
        return  $processOutput;
    }
}
