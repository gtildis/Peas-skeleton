<?php

include "./Pea.php";

// constants
$NUMBER_OF_CHROMOSOMES = 4;


function displayPea($args)
{
    global  $NUMBER_OF_CHROMOSOMES;

    $argsString = json_encode($args);
    echo "Passed arguments: $argsString\n";

    // Check if the number of arguments is exactly the number of Chromosomes
    if (count($args) !== $NUMBER_OF_CHROMOSOMES) {
        echo "Error: Invalid number of arguments. Please provide exactly four hidden variables.\n";
        return;
    }

    // Initialize arrays to store the chromosomes divided by type
    $colorGenes = [];
    $sweetness = [];

    // Divides the chromosomes based on type
    divideChromosomes($args, $colorGenes, $sweetness);

    // Creates new Pea with the divided genes 
    $pea = new Pea($colorGenes, $sweetness);


    // Checking if the format is valid with a helper reusable function
    if (!$pea->isValid()) {
        echo "Error: Please provide exactly two 'Y'/'g' values and two numeric values from 0 to 100.\n";
        return;
    }


    $pea->display();
}

function generatePea($args)
{
    global $NUMBER_OF_CHROMOSOMES;

    // Ensure we have exactly 8 arguments, 4 for each parent.
    if (count($args) !== $NUMBER_OF_CHROMOSOMES * 2) {
        echo "Error: Invalid number of arguments. Please provide exactly eight hidden variables (four for each parent).\n";
        return;
    }

    // Split the arrays into parents
    $firstArgs = array_slice($args, 0, $NUMBER_OF_CHROMOSOMES);
    $secondArgs = array_slice($args, $NUMBER_OF_CHROMOSOMES);

    // Initialize arrays to store the chromosomes divided by type
    $parentAColorGenes = [];
    $parentASweetness = [];
    $parentBColorGenes = [];
    $parentBSweetness = [];

    // Stores variables for both parent A and parent B
    divideChromosomes($firstArgs, $parentAColorGenes, $parentASweetness);
    divideChromosomes($secondArgs, $parentBColorGenes, $parentBSweetness);

    // Create the parent peas
    $parentA = new Pea($parentAColorGenes, $parentASweetness);
    $parentB = new Pea($parentBColorGenes, $parentBSweetness);

    // Check if both parent A and parent B have the correct format
    if (!$parentA->isValid() || !$parentB->isValid()) {
        echo "Error: Each parent must have two numeric values from 0 to 100 and two strings 'Y' or 'g' in lowercase.\n";
        return;
    }

    $parentA->createOffspring($parentB);
}

// Stores the chromosomes based on type
function divideChromosomes($chromosomes, &$colorGenes, &$sweetness)
{
    foreach ($chromosomes as $arg) {
        $arg = strtolower($arg);

        if (in_array($arg, ['y', 'g'])) {
            $colorGenes[] = $arg;
        } else {
            $sweetness[] = $arg;
        }
    }
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
