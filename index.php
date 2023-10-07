 <?php



    function displayPea($args)
    {
        $argsString = json_encode($args);
        echo "Passed arguments: $argsString\n";

        // Check if the number of arguments is exactly 4
        if (count($args) !== 4) {
            echo "Error: Invalid number of arguments. Please provide exactly four hidden variables.\n";
            return;
        }



        // Initialize an array to store the chromosomes divided by type
        $yOrG = [];
        $numeric = [];

        // Checking if the format is valid with a helper reusable function 
        $isValid = isValidFormat($args, $yOrG, $numeric);


        if ($isValid) {
            // Filtering the numeric values
            $sweetnessValues = array_filter($args, 'is_numeric');

            // Should return the Average
            $sweetnessAverage = (int)(array_sum($sweetnessValues) / count($numeric));

            // Should return Y if there is at least one Y on the args
            $visibleValue = in_array(strtolower('y'), array_map('strtolower', $yOrG)) ? 'Y' : 'g';


            echo "Sweetness Average: " . $sweetnessAverage . "\n";
            echo "Green/Yellow: " . $visibleValue . "\n";
            echo $visibleValue . ' ';
            echo $sweetnessAverage . "\n";
        } else {
            echo "Error: Please provide exactly two 'Y'/'g' values and two numeric values from 0 to 100.\n";
        }
    }


    function generatePea($args)
    {
        // Ensure we have exactly 8 arguments
        if (count($args) !== 8) {
            echo "Error: Invalid number of arguments. Please provide exactly eight hidden variables (four for each parent).\n";
            return;
        }

        //split the arrays to parents
        $parentA = array_slice($args, 0, 4);
        $parentB = array_slice($args, 4);


        // Initialize an array to store the chromosomes divided by type
        $yOrG = [];
        $numeric = [];


        // Check if the format is valid and store variables for both parent A and parent B
        $isValidParentA = isValidFormat($parentA, $yOrG, $numeric);
        $isValidParentB = isValidFormat($parentB, $yOrG, $numeric);



        // Check if both parent A and parent B have the correct format
        if ($isValidParentA && $isValidParentB) {

            // Initialize an array to store the chromosomes arrays
            $cArrays = [];



            $numCArrays = count($yOrG) / 2;

            // Loop to create and populate the chromosomes arrays
            for ($i = 0; $i < $numCArrays; $i++) {
                array_push($cArrays, [$yOrG[$i], $yOrG[$i + 2]]);
            }

            for ($i = 0; $i < $numCArrays; $i++) {
                array_push($cArrays, [$numeric[$i], $numeric[$i + 2]]);
            }




            // Initialize an array to store chosen entries
            $chosenEntries = [];


            // Loop through each of the chromosomes arrays based on the number of the chromosomes
            for ($i = 0; $i < count($yOrG); $i++) {
                $randomIndex = rand(0, 1);

                // Add the chosen entry to the $chosenEntries array
                $chosenEntries[] = $cArrays[$i][$randomIndex];
            }

            // Shuffle the array
            shuffle($chosenEntries);

            // Return the 'y' to uppercase
            $chosenEntries = array_map(function ($entry) {
                return strtolower($entry) === 'y' ? strtoupper($entry) : $entry;
            }, $chosenEntries);



            $newPea = json_encode($chosenEntries);

            // Return the chosen entries
            echo "New Pea: " . $newPea . "\n";
        } else {
            echo "Error: Each parent must have two numeric values from 0 to 100 and two strings 'Y' or 'g' in lowercase.\n";
            return;
        }
    }


    // check if the choromosomes are in the correct format and stores them based on type
    function isValidFormat($chromosomes, &$yOrG, &$numeric)
    {

        $currentYorG = [];
        $currentNumeric = [];

        foreach ($chromosomes as $arg) {
            if (strtolower($arg) === 'y' || strtolower($arg) === 'g') {
                $yOrG[] = $arg;
                $currentYorG[] = $arg;
            } elseif (is_numeric($arg)) {
                $numeric[] = $arg;
                $currentNumeric[] = $arg;
            } else {
                return false; // Invalid argument format
            }
        }

        return count($currentYorG) === 2 && count($currentNumeric) === 2;
    }

    if (count($argv) < 2) {
        echo "Usage: php index.php <command> [args]\n";
        return;
    }

    switch ($argv[1]) {
        case "display":
            displayPea(array_slice($argv, 2));
            break;
        case "generate":
            generatePea(array_slice($argv, 2));
            break;
        default:
            echo "Please use `php index.php display` or `php index.php generate`\n";
            return;
    }




    ?>