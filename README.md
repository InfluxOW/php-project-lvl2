# File comparator

#### App for finding differences between two .json or.yaml files

Description: https://ru.hexlet.io/professions/php/projects/48

[![Maintainability](https://api.codeclimate.com/v1/badges/28a51604ba3626ea12d3/maintainability)](https://codeclimate.com/github/InfluxOW/php-project-lvl2/maintainability)
[![Build Status](https://travis-ci.org/InfluxOW/php-project-lvl2.svg?branch=master)](https://travis-ci.org/InfluxOW/php-project-lvl2)

$ installation process\
[![asciicast](https://asciinema.org/a/DeHm2Rjew4AxdrCSYYtAhMGH7.svg)](https://asciinema.org/a/DeHm2Rjew4AxdrCSYYtAhMGH7)\
$ comparing 2 flat `.json` files with **plain**, **text** and **json** renderers\
[![asciicast](https://asciinema.org/a/Jq8OnAiFRZxDLV0j2A6Eea5Kg.svg)](https://asciinema.org/a/Jq8OnAiFRZxDLV0j2A6Eea5Kg)\
$ comparing 2 nested `.yaml` files with **plain**, **text** and **json** renderers\
[![asciicast](https://asciinema.org/a/MVBw8RukpIPhxYGIXOR6Lk1d0.svg)](https://asciinema.org/a/MVBw8RukpIPhxYGIXOR6Lk1d0)

---

## How To Install
`composer global require influx/php-project-lvl2`

---

## Usage
    gendiff (-h|--help)
    gendiff (-v|--version)
    gendiff [--format <fmt>] <firstFile> <secondFile>
