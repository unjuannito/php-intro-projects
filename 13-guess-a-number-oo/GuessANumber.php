<?php 
    class GuessANumber{
        private $minNumber;
        private $maxNumber;
        private $number;
        private $leftTries;

        public function __construct($minNumber, $maxNumber, $nTries) {
            $this->minNumber = $minNumber;
            $this->maxNumber = $maxNumber;
            $this->number = rand($minNumber, $maxNumber);
            $this->leftTries = $nTries;

        }
        public function getMinNumber() {
            return $this->minNumber;
        }
        public function getMaxNumber() {
            return $this->maxNumber;
        }
        public function getNumber() {
            return $this->number;
        }

        public function getLeftTries() {
            return $this->leftTries;
        }

        public function gameRes($guess) {
            $this->leftTries--;
            $isHigherOrLower = "";
            if($guess == $this->number) $gameRes = 1;
            else if($this->leftTries <= 0) $gameRes = -1;
            else {
                $gameRes = 0;
                if ($guess > $this->number) {
                    $isHigherOrLower = "Is Lower";
                }else $isHigherOrLower = "Is Higher";
            }
            return [$gameRes, $isHigherOrLower];
        }
    }

?>