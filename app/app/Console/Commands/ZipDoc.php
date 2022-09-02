<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ZipDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zip:folder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {  $path =public_path() . '/uploads';
        $zip_file = 'docs';
        $zip = new \ZipArchive();
        $files_limit=4;
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));


        $filess=[];
        foreach($files as $name=>$file){
            if($file->isDir()!=true){
                $filess[]=$file;
            }
        }
        $files_count=count($filess);
        $rem=$files_count % $files_limit;
        if ($rem>0){
            $archives=(($files_count-$rem)/$files_limit)+1;
        }else{
            $archives=(($files_count-$rem)/$files_limit);
        }
        for($i=0;$i<$archives;$i++){
            if ($i==($archives-1)){
                $rrem=$rem;
            }else{
                $rrem=$files_limit;  $f=$i*$files_limit;
            }
            $file_index=$i*$files_limit;
            $zip->open(public_path($zip_file.'_'.$i.'.zip'), \ZipArchive::CREATE);
            for ($a=0;$a<$rrem;$a++){
                $filePath = $filess[$file_index]->getRealPath();
                $relativePath = 'docs_content/' . substr($filePath, strlen($path) + 1);
                $zip->addFile($filePath,$relativePath);
                if($file_index<$files_count){
                    $file_index++;
                }
            }
            $zip->close();
        }

        return $this->info('Zip Completed');
    }
}
