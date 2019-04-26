<?php

/**
 * name        : temple
 * description : A tiny and simple template engine.
 * created     : 21.12.2018
 *
 * author      : floppyist
 * 
 * update      : 22.04.2019
 */
class Temple {
  private $debug = false;

  private $templates;
  private $components;

  function __construct( $dirTemplates, $dirComponents, $debug ) {
    $this->debug      = $debug;
    $this->templates  = $this->loadTemplates( $dirTemplates );
    $this->components = $this->loadComponents( $dirComponents );
  }

  private function loadTemplates( $dir ) {
    $paths = glob( "$dir/*.tpl" );

    # iterate each template which was found
    foreach ( $paths as $path ) {
      # split into lines
      $lines = explode( "\n", file_get_contents( $path ) );
      $text  = "";

      foreach ( $lines as $line ) {
        # if component tag was found in template put it into the templates array
        if ( preg_match( "/{{(.*)}}/", $line, $match ) ) {
          $templates[ pathinfo( $path, PATHINFO_FILENAME ) ][ "component" ][] = $match[ 1 ];
        }

        # always write the whole text
        $text .= "\n$line";

        # push text into array
        $templates[ pathinfo( $path, PATHINFO_FILENAME ) ][ "text" ] = $text;
      }
    }

    return $templates;
  }

  private function loadComponents( $dir ) {
    $paths = glob( "$dir/*.html" );

    # iterate each component which was found
    foreach ( $paths as $path ) {
      # split into lines
      $lines = explode( "\n", file_get_contents( $path ) );
      $text  = "";

      foreach ( $lines as $line ) {
        # if attribute tag was found in component put it into the templates array
        if ( preg_match( "/{{(.*)}}/", $line, $match ) ) {
          $components[ pathinfo( $path, PATHINFO_FILENAME ) ][ "attribute" ][] = $match[ 1 ];
        }

        # always write the whole text
        $text .= "\n$line";

        # push text into array
        $components[ pathinfo( $path, PATHINFO_FILENAME ) ][ "text" ] = $text;
      }
    }

    return $components;
  }

  /**
   * Renders the given template and resolves all attributes in the components
   */
  public function renderTemplate( $template, $attributes ) {
    # check if given template exists
    if ( isset( $this->templates[ $template ] ) ) {
      # write text into variable for processing
      $template_content = $this->templates[ $template ][ "text" ];

      # iterate all components which are related to the current template
      foreach ( $this->templates[ $template ][ "component" ] as $component ) {
        # check if the current component really exists
        if ( isset( $this->components[ $component ] ) ) {
          $component_placeholder = "{{" . $component . "}}";
          $component_content = $this->components[ $component ][ "text" ];

          # if no attribute are found in current component, simply replace the component placeholder with the content
          if ( isset( $this->components[ $component ][ "attribute" ] ) ) {
            # iterate all attributes which are related to the current component
            foreach ( $this->components[ $component ][ "attribute" ] as $component_attribute ) {
              $attribute_placeholder = "{{" . $component_attribute . "}}";

              if ( isset( $attributes[ $component_attribute ] ) ) {
                $component_content = str_replace( $attribute_placeholder, $attributes[ $component_attribute ], $component_content );
              } else {
                $component_content = str_replace( $attribute_placeholder, "", $component_content );

                if ( $this->debug ) {
                  print( "ATTRIBUTE [ $component_attribute ] not given." );
                }
              }
            }
          }

          $template_content = str_replace( $component_placeholder, $component_content, $template_content );
        } else {
          if ( $this->debug ) {
            print( "COMPONENT [ $component ] does not exist." );
          }
        }
      }
    } else {
      if ( $this->debug ) {
        print( "TEMPLATE [ $template ] does not exist." );
      }
    }

    print( $template_content );
  }
}

?>
