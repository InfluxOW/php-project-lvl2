<?php

namespace Differ\Cli;

use function Differ\DiffMaker\genDiff;

const HELP = <<<'DOC'

Generate diff

Usage:
  gendiff (-h|--help)
  gendiff (-v|--version)
  gendiff [--format <fmt>] <firstFile> <secondFile>

Options:
  -h --help                     Show this screen
  -v --version                  Show version
  --format <fmt>                Report format [default: pretty]
DOC;

function run()
{
    $args = getArgs(HELP);
    $pathToFile1 = $args["<firstFile>"];
    $pathToFile2 = $args["<secondFile>"];
    print_r(genDiff($pathToFile1, $pathToFile2));
}

function getArgs($content)
{
    return \Docopt::handle($content);
}
