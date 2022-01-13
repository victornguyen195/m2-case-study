<?php

declare(strict_types=1);

namespace Amasty\JetNonLatinFonts\Model\Font;

use Magento\Framework\Module\Dir;
use Magento\Framework\Module\Dir\Reader;
use Magento\Framework\Filesystem\Driver\File as FileDriver;
use Magento\Framework\Filesystem\Io\File as IoFile;

class FileReader
{
    const MODULE_NAME = 'Amasty_JetNonLatinFonts';

    /**
     * @var FileDriver
     */
    private $fileDriver;

    /**
     * @var IoFile
     */
    private $ioFile;

    /**
     * @var Reader
     */
    private $moduleDirReader;

    public function __construct(
        Reader $moduleDirReader,
        FileDriver $fileDriver,
        IoFile $ioFile
    ) {
        $this->fileDriver = $fileDriver;
        $this->ioFile = $ioFile;
        $this->moduleDirReader = $moduleDirReader;
    }

    /**
     * @return array
     */
    public function getFileNames(): array
    {
        $files = $this->fileDriver->readDirectory($this->getDir());
        $resultFiles = [];
        foreach ($files as $file) {
            if ($this->fileDriver->isFile($file)) {
                $resultFiles[] = $this->ioFile->getPathinfo($file)['filename'];
            }
        }

        return array_unique($resultFiles);
    }

    /**
     * @param string $fileName
     * @return string
     */
    public function getFileContent(string $fileName): string
    {
        return $this->fileDriver->fileGetContents($this->getDir() . $fileName . '.woff');
    }

    /**
     * @return string
     */
    private function getDir(): string
    {
        return $this->moduleDirReader
            ->getModuleDir(Dir::MODULE_VIEW_DIR, self::MODULE_NAME) . '/frontend/web/fonts/';
    }
}
