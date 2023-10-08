<?php
class Pea
{

  private $colorGenes = [];
  private $sweetness = [];

  private $DISPLAY_VALUE_Y_CHROMOSOME = 'Y';
  private $DISPLAY_VALUE_G_CHROMOSOME = 'g';
  private $COMPARISON_NUMBER_OF_CHROMOSOMES = 2;


  public function __construct($colorGenes, $sweetness)
  {
    $this->colorGenes = $colorGenes;
    $this->sweetness = $sweetness;
  }

  public function display()
  {
    // Calculate the sweetness average
    $sweetnessAverage = $this->calculateSweetness();
    // Determine the color value
    $colorValue = $this->calculateColor();

    echo "Sweetness Average: " . $sweetnessAverage . "\n";
    echo "Green/Yellow: " . $colorValue . "\n";
  }

  // Calculates the average
  public function calculateSweetness()
  {
    return count($this->sweetness) > 0 ? (int)(array_sum($this->sweetness) / count($this->sweetness)) : 0;
  }

  // Checks if there is at least 1 Y and determinates the color
  public function calculateColor()
  {
    return in_array('y', $this->colorGenes) ? $this->DISPLAY_VALUE_Y_CHROMOSOME : $this->DISPLAY_VALUE_G_CHROMOSOME;
  }

  // Checks if the format of the pea is valid 
  public function isValid()
  {
    if (count($this->colorGenes) !== $this->COMPARISON_NUMBER_OF_CHROMOSOMES || count($this->sweetness) !== $this->COMPARISON_NUMBER_OF_CHROMOSOMES) {
      return false;
    }

    foreach ($this->sweetness as $value) {
      if ($value < 0 || $value > 100) {
        return false;
      }
    }

    return true;
  }

  // Creates a new pea of this pea and another parent
  public function createOffspring($otherParent)
  {

    // Initialize an array to store the chromosomes arrays
    $toCompareColorGenes = [];
    $toCompareSweetness = [];

    // Loop to create and populate the chromosomes arrays in the right order
    for ($i = 0; $i < $this->COMPARISON_NUMBER_OF_CHROMOSOMES; $i++) {
      array_push($toCompareColorGenes, [$this->colorGenes[$i], $otherParent->colorGenes[$i]]);
      array_push($toCompareSweetness, [$this->sweetness[$i], $otherParent->sweetness[$i]]);
    }

    // Initialize an array to store chosen entries
    $chosenColorGenes = [];
    $chosenSweetness = [];

    // Loop through each of the chromosomes arrays based on the number of chromosomes and randomly choose one chromosome each time
    for ($i = 0; $i < $this->COMPARISON_NUMBER_OF_CHROMOSOMES; $i++) {

      // Add the chosen entry to the $chosenEntries array
      $chosenColorGenes[] = $toCompareColorGenes[$i][rand(0, 1)];
      $chosenSweetness[] = $toCompareSweetness[$i][rand(0, 1)];
    }

    // creates the new Pea instance with the chosen genes
    $offspring = new Pea($chosenColorGenes, $chosenSweetness);
    echo "Color Genes: " . json_encode($chosenColorGenes) . "\n";
    echo "Sweetness Genes: " . json_encode($chosenSweetness) . "\n";

    $offspring->display();
    return $offspring;
  }
}
