<?php

    class game{

        private $illustration = ['░░', '▓▓'];

        public function __construct($map = null){
            $this->map = $map;
        }

        private function check_map(){
            if($this->map)
                return true;
            else
                throw new Exception("Error! The map value is not specified.");
        }

        public function generate($size, $p){
            for ($i=0; $i < $size; $i++) { 
                for ($j=0; $j < $size; $j++) { 
                    $matrix[$i][$j] = rand(0, 100) <= $p ? $this->illustration[1] : $this->illustration[0];
                }
            }
            $this->map = $matrix;
        }

        public function compile(){
            $this->check_map();
            $size = count($this->map);
            $string = '';
            for ($i=0; $i < $size; $i++) { 
                for ($j=0; $j < $size; $j++) { 
                    $string .= $this->map[$i][$j];
                }
                $string .= "\n";
            }
            return $string;
        }

        private function status($date){
            $count = 0;
            $max = count($this->map);
            for($i = -1; $i < 2; $i++)
                for($j = -1; $j < 2; $j++)
                    if(($i != 0 || $j != 0) && $max > $date[0] + $i && $max > $date[1] + $j && 0 <= $date[0] + $i && 0 <= $date[1] + $j)
                        $count += $this->map[$date[0]+$i][$date[1]+$j] == $this->illustration[1] ? 1 : 0;

            return $count < 2 || $count > 3 ? 1 : $count;
        }

        private function offset_map(){
            $size = count($this->map);
            for ($i=0; $i < $size; $i++) { 
                for ($j=0; $j < $size; $j++) { 
                    $this->map[$i][$j] = str_replace('2', $this->illustration[1], $this->map[$i][$j]);
                }
            }
        }

        public function update_map(){
            $this->check_life();
            $this->check_die();
            $this->offset_map();
        }

        private function check_die(){
            $size = count($this->map);
            $map = $this->map;
            for ($i=0; $i < $size; $i++) { 
                for ($j=0; $j < $size; $j++) { 
                    if($this->map[$i][$j] == $this->illustration[1]){
                        $map[$i][$j] = $this->status([$i, $j]) == 1 ? $this->illustration[0] : 2;
                    }
                }
            }
            $this->map = $map;
        }

        private function check_life(){
            $size = count($this->map);
            $map = $this->map;
            for ($i=0; $i < $size; $i++) { 
                for ($j=0; $j < $size; $j++) { 
                    if($this->map[$i][$j] == $this->illustration[0]){
                        $map[$i][$j] = $this->status([$i, $j]) < 3 ? $this->illustration[0] : 2;
                    }
                }
            }
            $this->map = $map;
        }

    }