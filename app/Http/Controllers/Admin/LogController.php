<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Links;
use App\Domains;

class LogController extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('admin'); 
    }

    public function linklogs(Links $link,Request $request){
		$_logs = glob(base_path()."/storage/logs/links/link$link->id-*.log", GLOB_BRACE);
        $logs = [];
        foreach($_logs as $_log){
            $logs[] = ["path" => "links/".explode("/", $_log)[count(explode("/", $_log)) - 1], "size" => $this->filesize_formatted($_log)];
        }
		return view('admin.logs.index')->with('logs', $logs);
    }

    public function domainlogs(Domains $domain,Request $request){
		$_logs = glob(base_path()."/storage/logs/domains/$domain->domain-*.log", GLOB_BRACE);
        $logs = [];
        foreach($_logs as $_log){
            $logs[] = ["path" => "domains/".explode("/", $_log)[count(explode("/", $_log)) - 1], "size" => $this->filesize_formatted($_log)];
        }
		return view('admin.logs.index')->with('logs', $logs);
    }

    public function showlogs(Request $request){
    	$file = $request->get('log', "") ?? "";
    	$path = base_path()."/storage/logs/".$file;
    	header("Content-Type: text/plain");
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
    	if(empty($file) || !file_exists($path) || is_dir($path)){
    		echo "File not found" ;
    		exit;
    	}
    	$fp = fopen($path, 'r');
		$pos = -2;
		$lines = array();
		$currentLine = '';
		while (-1 !== fseek($fp, $pos, SEEK_END)) {
		    $char = fgetc($fp);
		    if (PHP_EOL == $char) {
		            $lines[] = $currentLine;
		            $currentLine = '';
		    } else {
		            $currentLine = $char . $currentLine;
		    }
		    $pos--;
		}
		$lines[] = $currentLine;
		foreach($lines as $line){
			echo $line ."\n";
		}
		exit;
    }


	public function deletelog(Request $request)
	{
		$file = $request->get('log', "") ?? "";
    	$path = base_path()."/storage/logs/".$file;
    	if(empty($file) || !file_exists($path) || is_dir($path)){
    		return back()->with('error', "$file log not found");
    	}
		if(unlink($path)){
			return back()->with('status', "Successfully deleted log $file");
		}
		return back()->with('error', "Unable to delete log $file");
	}

	public function filesize_formatted($path)
  {
        $size = filesize($path);
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
  /* function downloadcsv end 7 march 2019 Begin */
  public function downloadcsv(Request $request)
  {
    error_reporting(0);
    $file = $request->get('log', "") ?? "";
    $path = base_path()."/storage/logs/".$file;

    header('Content-type: application/csv');
    header('Content-Disposition: attachment; filename='.time().'.csv');
    $fh = fopen($path,'r');
    $f = fopen('php://output', 'w');
    $ii = 0;
    while ($line = fgets($fh)) {
        $line= strstr($line, '{');
        $line= substr($line, 0, -3);
        $dataArray = $this->decodejson($line);
        $dataArrayHeader = array_keys($dataArray);
        if($ii==0){
          fputcsv($f,$dataArrayHeader); $ii++;
        }
        $line3 = $line[3];
        $line[8]=preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $line[8]);
        $line[9]=$line3[0];
        $line[10]=$line3[1];
        $line[3]="";
        $line[7]='';
        fputcsv($f,$dataArray);
    }
    fclose($f);
    fclose($fh);
  }

  /* function downloadcsv  7 march 2019 End*/


  /* function decodejson  7 march 2019 Begin*/
  public function decodejson($line)
  {
    $newdataarray = array();
    $line=json_decode($line,true);
    foreach($line as $key=>$value)
    {
        if(is_array($value))
        {
          foreach($value as $keyinner=>$valueinner){
            $newdataarray[$key.'_'.$keyinner] = $valueinner;
          }
        }else
        {
          $newdataarray[$key] = $value;
        }
   }
  return $newdataarray;
  }

  /* function decodejson  7 march 2019 End*/

}
