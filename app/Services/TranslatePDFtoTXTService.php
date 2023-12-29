<?php
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class TranslatePDFtoTXTService
{
  private $scriptPath;

  public function __construct()
  {
      $this->scriptPath = storage_path('Scripts/TranslateScriptPDFtoTXT.py');
  }

  public function runScriptTranslatePDFtoTXT($inputFilePath, $outputFilePath)
  {
      $process = new Process(['python', $this->scriptPath, $inputFilePath, $outputFilePath]);

      try {
          $process->mustRun();

          return $process->getOutput();
      } catch (ProcessFailedException $exception) {
          throw new \Exception("Ошибка выполнения скрипта Python: {$exception->getMessage()}");
      }
  }
}