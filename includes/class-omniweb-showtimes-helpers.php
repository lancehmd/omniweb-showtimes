<?php

class Omniweb_Showtimes_Helpers
{
    public static function get_template($template)
    {
        $template_slug = rtrim($template, '.php');
        $template      = $template_slug.'.php';

        if ($theme_file = locate_template(['omniweb-showtimes/'.$template])) {
            $file = $theme_file;
        } elseif (file_exists(__DIR__.'/../templates/'.$template)) {
            $file = __DIR__.'/../templates/'.$template;
        } else {
            $file = null;
        }

        return $file;
    }

    public static function xml_to_array($xml, $options = [])
    {
        $defaults = [
            'namespaceSeparator' => ':',
            'attributePrefix'    => '@',   // Used to distinguish between attributes and nodes with the same name.
            'alwaysArray'        => [],    // Array of XML tag names which should always become arrays.
            'autoArray'          => true,  // only create arrays for tags which appear more than once
            'textContent'        => '$',   // key used for the text content of elements
            'autoText'           => true,  // skip textContent key if node has no attributes or child nodes
            'keySearch'          => false, // optional search and replace on tag and attribute names
            'keyReplace'         => false  // replace values for above search values (as passed to str_replace())
        ];

        $options         = array_merge($defaults, $options);
        $namespaces      = $xml->getDocNamespaces();
        $namespaces['']  = null; // Add base (empty) namespace
        $attributesArray = [];   // Get attributes from all namespaces

        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
                // Replace characters in attribute name
                if ($options['keySearch']):
                    $attributeName = str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
                endif;

                $attributeKey  = $options['attributePrefix'];
                $attributeKey .= ($prefix ? $prefix . $options['namespaceSeparator'] : '');
                $attributeKey .= $attributeName;

                $attributesArray[$attributeKey] = (string)$attribute;
            }
        }

        // Get child nodes from all namespaces
        $tagsArray = [];
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->children($namespace) as $childXml) {
                //recurse into child nodes
                $childArray = Omniweb_Showtimes_Helpers::xml_to_array($childXml, $options);
                list($childTagName, $childProperties) = each($childArray);

                //replace characters in tag name
                if ($options['keySearch']) $childTagName =
                        str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
                //add namespace prefix, if any
                if ($prefix) $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;

                if (!isset($tagsArray[$childTagName])) {
                    //only entry with this key
                    //test if tags of this type should always be arrays, no matter the element count
                    $tagsArray[$childTagName] =
                            in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
                            ? array($childProperties) : $childProperties;
                } elseif (
                    is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
                    === range(0, count($tagsArray[$childTagName]) - 1)
                ) {
                    //key already exists and is integer indexed array
                    $tagsArray[$childTagName][] = $childProperties;
                } else {
                    //key exists so convert to integer indexed array with previous value in position 0
                    $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
                }
            }
        }

        // Get text content of node
        $textContentArray = [];
        $plainText        = trim((string)$xml);

        if ($plainText !== '') $textContentArray[$options['textContent']] = $plainText;

        // Stick it all together
        $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
                ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;

        // Return node as anarray
        return [$xml->getName() => $propertiesArray];
    }
}
