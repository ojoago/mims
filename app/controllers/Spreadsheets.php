<?php
    class Spreadsheets extends Controller{
        public function __construct(){
          $this->writeFile=$this->model('Spreadsheet');
        }
        public function readFile(){
            if(@$_FILES['excelFile']['name']!=''){
                $allowed=array('xls','csv','xlsx');
                $ext=explode('.',$_FILES['excelFile']['name']);
                $fileExt=strtolower(end($ext));
                if(in_array($fileExt,$allowed)){
                    $file_name = time() . '.' . $fileExt;
                    move_uploaded_file($_FILES['excelFile']['tmp_name'], $file_name);
                    $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);
                    $spreadsheet = $reader->load($file_name);
                    unlink($file_name);
                    $data = $spreadsheet->getActiveSheet()->toArray();
                  $this->writeFile->writeMeterNumber($data);
                }else{
                    $data=['msg'=>'spreadsheet file only'];
                }
            }else {
                $data=['msg'=>'empty'];
            }
            $this->view('spreadsheets/batch',$data);
        }
    }
