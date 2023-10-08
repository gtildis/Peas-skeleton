# Getting set up

We suggest running this project in a docker container. Docker is a tool that allows for running applications in a
consistent environment which is isolated from the host computer. You are however welcome to run this anyway you feel most
comfortable!

## Running with docker

First install Docker for your OS (https://docs.docker.com/desktop/). Then, in a terminal in this directory run (replacing
PATH with the location of peas-skeleton on your host):

`docker run --rm --entrypoint sh -it -w /src -v PATH/peas-skeleton/src:/src php:8.2.11-cli-alpine3.18`

Docker should then download an image which can run php applications for you, and launch a shell. If you have any difficulty
getting it running with Docker, please get in touch.

## Running the skeleton

In a shell you can run `php index.php display` or `php index.php generate` and see the output of running the functions
in `src/index.php` along with any further arguments you provide to the command line.

## For the display function

You have to run `php index.php display arg1 arg2 arg3 arg4`.

Here's what each argument represents:

- `arg1`, `arg2`, `arg3`, and `arg4`:

These arguments control different aspects of the pea's properties and should adhere to the property-specific value ranges.
They may be "Y" or "g" for color or an integer ranging from 0 to 100 for sweetness.
The only thing you need to have in mind is that you need to provide two arguments that are numeric and two that are 'Y' or 'g'.

E.g:

- `php index.php display Y g 42 66`
- `php index.php display g 13 26 Y`
- `php index.php display 23 0 g Y`
- `php index.php display 100 g 12 g`

The order of the arguments doesn't matter. The only thing that you need to keep in mind is that you need to put two numeric
arguments between 0-100 and two arguments that are either 'Y' or 'g'.
This syntax will allow you to observe the visible properties of the pea based on the specified hidden genetic variables.

## For the generate function

You have to run `php index.php generate arg1 arg2 arg3 arg4 arg5 arg6 arg7 arg8`.

Here's what each argument represents:

- `arg1`, `arg2`, `arg3`, and `arg4`:

These first four arguments are the first parent of the new pea.These arguments control different aspects of the pea's properties and should adhere to the property-specific value ranges.
They may be "Y" or "g" for color or an integer ranging from 0 to 100 for sweetness.

- `arg5`, `arg6`, `arg7`, and `arg8`:

These second four arguments are the second parent of the new pea. Similar to the previous, they are following the same rules.

E.g:

- parent1: Y g 42 66
- parent2: g 13 26 g

* `php index.php generate Y g 42 66 g 13 26 g`

- parent1: 23 0 g Y
- parent2: 100 g 12 Y

* `php index.php generate 23 0 g Y 100 g 12 Y`

- parent1: 55 11 g Y
- parent2: 7 g 99 g

* `php index.php generate 55 11 g Y 7 g 99 g`

The order of the arguments for each parent doesn't matter, only the fact that you need to provide
two parents in a row and not mix their genes, as you can see in the example above.
