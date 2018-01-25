<?php

    /**
     * @author theodor-flavian hanu
     * Date: 9 Nov 2015
     * Time: 17:43
     */
    class Artemis_Swp_Css_Manager {

        private $css   = array();

        private $media = array();

        public function addRule( $selector, $rule, $value, $media = '' ) {
            if( $media ) {
                $this->addMedia( $media, $selector, $rule, $value );
            }
            else {

                if( isset( $this->css[$selector] ) ) {
                    $this->css[$selector][$rule] = $value;
                }
                else {
                    $this->css[$selector] = array(
                        $rule => $value
                    );
                }
            }
        }

        public function addMedia( $media, $selector, $rule, $value ) {
            if( !$media ) return;
            if( isset( $this->media[$media] ) ) {
                if( isset( $this->media[$media][$selector] ) ) {
                    $this->media[$selector][$rule] = $value;
                }
                else {
                    $this->media[$media][$selector] = array(
                        $rule => $value
                    );
                }
            }
            else {
                $this->media[$media] = array(
                    $selector => array( $rule => $value )
                );
            }
        }

        public function addMediaMultipleRules( $media, $selector, $rules ) {
            foreach( $rules as $rule => $value ) {
                $this->addMedia( $media, $selector, $rule, $value );
            }
        }

        public function removeMedia( $media, $selector = '', $rule = '' ) {
            if( isset( $this->media[$media] ) ) {
                if( $selector && isset( $this->media[$media][$selector] ) ) {
                    if( $rule && isset( $this->media[$media][$selector][$rule] ) ) {
                        unset( $this->media[$media][$selector][$rule] );
                    }
                    else {
                        unset( $this->media[$media][$selector] );
                    }
                }
                else {
                    unset( $this->media[$media] );
                }
            }
        }

        public function addMultiple( $selector, $rules, $media = '' ) {
            foreach( $rules as $rule => $value ) {
                $this->addRule( $selector, $rule, $value, $media );
            }
        }

        public function updateRule( $selector, $rule, $value = '', $media = '' ) {
            if( is_array( $rule ) ) {
                $this->addMultiple( $selector, $rule, $media );
            }
            else {
                $this->addRule( $selector, $rule, $value, $media );
            }
        }

        public function removeRule( $selector, $rule = '', $media = '' ) {
            if( $media ) {
                $this->removeMedia( $media, $selector, $rule );
            }
            if( isset( $this->css[$selector] ) ) {
                if( $rule && isset( $this->css[$selector][$rule] ) ) {
                    unset( $this->css[$selector][$rule] );
                }
                else {
                    unset( $this->css[$selector] );
                }
            }
            if( empty( $this->css[$selector] ) ) {
                unset( $this->css[$selector] );
            }
        }

        protected function outputRules( $groups ) {
            $output = '';
            foreach( $groups as $selector => $rules ) {
                $output .= $selector . '{';
                foreach( $rules as $rule => $value ) {
                    $output .= $rule . ': ' . $value . ';';
                }
                $output .= '}';
            }
            return $output;
        }

        /**
         * @return string
         */
        public function getCss() {
            $output = '';
            if( count( $this->css ) ) {
                $output .= $this->outputRules( $this->css );
            }

            if( count( $this->media ) ) {
                foreach( $this->media as $query => $groups ) {
                    $output .= "@media ( $query ) {";
                    $output .= $this->outputRules( $groups );
                    $output .= "}";
                }
            }
            return $output;
        }
    }
