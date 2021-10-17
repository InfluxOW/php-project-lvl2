<?php

namespace Differ;

use Differ\Exceptions\DifferException;
use Docopt;

class Cli
{
    private const EXIT_CODE_SUCCESS = 0;
    private const EXIT_CODE_GENERIC_ERROR = 1;

    private const HELP = <<<'DOC'

    Generate diff
    
    Usage:
      gendiff (-h|--help)
      gendiff (-v|--version)
      gendiff [--format <fmt>] <firstFile> <secondFile>
    
    Options:
      -h --help                     Show this screen
      -v --version                  Show version
      --format <fmt>                Report format [default: plain]

    DOC;

    public static function run(): void
    {
        $args = Docopt::handle(self::HELP, ['version' => 'v1.0.0']);

        $pathToFile1 = $args["<firstFile>"];
        $pathToFile2 = $args["<secondFile>"];
        $format = $args['--format'];

        try {
            $diff = DiffMaker::genDiff($pathToFile1, $pathToFile2, $format);
        } catch (DifferException $e) {
            print_r($e->prepareMessage());
            exit(self::EXIT_CODE_GENERIC_ERROR);
        }

        print_r($diff);
        exit(self::EXIT_CODE_SUCCESS);
    }
}
