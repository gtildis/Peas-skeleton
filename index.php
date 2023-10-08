 <?php

    //constants
    $COMPARISON_NUMBER_OF_CHROMOSOMES = 2;
    $NUMBER_OF_CHROMOSOMES = 4;

    function displayPea($args)
    {
        global  $NUMBER_OF_CHROMOSOMES;

        $argsString = json_encode($args);
        echo "Passed arguments: $argsString\n";

        // Check if the number of arguments is exactly the number of Chromosomes
        if (count($args) !==  $NUMBER_OF_CHROMOSOMES) {
            echo "Error: Invalid number of arguments. Please provide exactly four hidden variables.\n";
            return;
        }

        // Initialize arrays to store the chromosomes divided by type
        $yOrG = [];
        $numeric = [];
        if (!devideChromosomes($args, $yOrG, $numeric)) {
            echo "Error: Invalid argument format.  Please provide valid chromosomes, exactly two 'Y'/'g' values and two numeric values from 0 to 100.\n";
            return;
        }

        // Checking if the format is valid with a helper reusable function
        if (isValidFormat($yOrG, $numeric)) {
            // Calculate the sweetness average
            $sweetnessAverage = count($numeric) > 0 ? (int)(array_sum($numeric) / count($numeric)) : 0;
            // Determine the color value
            $colorValue = in_array(strtolower('y'), array_map('strtolower', $yOrG)) ? 'Y' : 'g';

            echo "Sweetness Average: " . $sweetnessAverage . "\n";
            echo "Green/Yellow: " . $colorValue . "\n";

            echo $colorValue . ' ';
            echo $sweetnessAverage . "\n";
        } else {
            echo "Error: Please provide exactly two 'Y'/'g' values and two numeric values from 0 to 100.\n";
        }
    }

    function generatePea($args)
    {
        global $NUMBER_OF_CHROMOSOMES;
        global $COMPARISON_NUMBER_OF_CHROMOSOMES;


        // Ensure we have exactly 8 arguments
        if (count($args) !== $NUMBER_OF_CHROMOSOMES * 2) {
            echo "Error: Invalid number of arguments. Please provide exactly eight hidden variables (four for each parent).\n";
            return;
        }

        // Split the arrays into parents
        $parentA = array_slice($args, 0, $NUMBER_OF_CHROMOSOMES);
        $parentB = array_slice($args, $NUMBER_OF_CHROMOSOMES);

        // Initialize arrays to store the chromosomes divided by type
        $parentAyOrG = [];
        $parentAnumeric = [];
        $parentByOrG = [];
        $parentBnumeric = [];

        // Check if the format is valid and store variables for both parent A and parent B
        $devideParentA = devideChromosomes($parentA, $parentAyOrG, $parentAnumeric);
        $devideParentB = devideChromosomes($parentB, $parentByOrG, $parentBnumeric);

        // Check if both parent A and parent B have the correct format
        if (isValidFormat($parentAyOrG, $parentAnumeric) && isValidFormat($parentByOrG, $parentBnumeric)) {
            // Initialize an array to store the chromosomes arrays
            $cArrays = [];

            // Loop to create and populate the chromosomes arrays in the right order
            for ($i = 0; $i < $COMPARISON_NUMBER_OF_CHROMOSOMES; $i++) {
                array_push($cArrays, [$parentAyOrG[$i], $parentByOrG[$i]]);
                array_push($cArrays, [$parentAnumeric[$i], $parentBnumeric[$i]]);
            }

            // Initialize an array to store chosen entries
            $chosenEntries = [];

            // Loop through each of the chromosomes arrays based on the number of chromosomes and randomly take one chromosome each time
            for ($i = 0; $i < $NUMBER_OF_CHROMOSOMES; $i++) {
                $randomIndex = rand(0, 1);
                // Add the chosen entry to the $chosenEntries array
                $chosenEntries[] = $cArrays[$i][$randomIndex];
            }

            // Return the 'y' to uppercase
            $chosenEntries = array_map(function ($entry) {
                return strtolower($entry) === 'y' ? strtoupper($entry) : $entry;
            }, $chosenEntries);

            $newPea = json_encode($chosenEntries);

            // Return the chosen entries
            echo "New Pea: " . $newPea . "\n";
        } else {
            echo "Error: Each parent must have two numeric values from 0 to 100 and two strings 'Y' or 'g' in lowercase.\n";
        }
    }

    // Stores them based on type and returns true if success
    function devideChromosomes($chromosomes, &$yOrG, &$numeric)
    {

        foreach ($chromosomes as $arg) {
            if (strtolower($arg) === 'y' || strtolower($arg) === 'g') {
                $yOrG[] = $arg;
            } elseif (is_numeric($arg)) {
                $numeric[] = $arg;
            } else {
                echo 'Error: Something went bad on dividing the chromosomes.';
                return false; // Invalid argument format
            }
        }

        return true; // Valid format
    }

    // Check if the chromosomes are in the correct format
    function isValidFormat(&$arrayOfyOrG, &$arrayOfNumeric)
    {
        global $COMPARISON_NUMBER_OF_CHROMOSOMES;

        if (count($arrayOfNumeric) !== $COMPARISON_NUMBER_OF_CHROMOSOMES || count($arrayOfyOrG) !== $COMPARISON_NUMBER_OF_CHROMOSOMES) {
            return false;
        }

        foreach ($arrayOfNumeric as $value) {
            if ($value < 0 || $value > 100) {
                return false;
            }
        }

        return true;
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