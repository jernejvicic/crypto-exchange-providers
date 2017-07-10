# Crypto exchange providers

A collection of programs that provide ticker data from crypto exchanges

File structure
==============
Each exchange gets its on directory that MUST contain a file called "run" that contains a single line that contains a command that runs the program, you can assume that the current working directory is where the run file is located

config.json is an optional config file that is NOT included in git, use it to save application keys that excganges may require, please also include config.json.dist file that describes config.json content without including any private data

please also include a README.md file that contains instructions on how to setup possible dependencies

Output
======
output on stdout is a tab separated list that looks like this:
```sh
exchange_name <tab> unix timestamp <tab> currency1 <tab> currency2 <tab> ratio <tab> volume (last 24h)
```

exchange_name is the url slug for the exchange on coinmarketcap.com
currency1 and currency 2 are url slugs for the curreny on coinmarketcap.com

Exchanges
========
Currently available exchanges are:
  - Kraken