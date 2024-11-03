<?php
use Kirby\Cms\App as Kirby;

Kirby::plugin('estd/kirby-modify-text', [
    'options' => [
        'version' => '1.0.0',
        'description' => 'A plugin to add custom attributes to Kirby CMS writer block',
        'license' => 'MIT',
        'author' => 'Robert Farrelly',
        'homepage' => 'https://github.com/veryrobert/kirby-writer-attributes',
    ],
    'fieldMethods' => [
        'modifyTag' => function ($field, array $options = []) {
            // Default values
            $attributes = $options['attributes'] ?? [];
            $class = $options['class'] ?? '';
            $newTag = $options['tag'] ?? null;
            $styles = $options['styles'] ?? [];
    
            // If all options are empty, return the field unmodified
            if (empty($attributes) && empty($class) && empty($newTag) && empty($styles)) {
                return $field;
            }
    
            $field->value = preg_replace_callback(
                '/<([a-zA-Z1-6]+)([^>]*)>(.*?)<\/\\1>/s',
                function ($match) use ($attributes, $class, $newTag, $styles) {
                    $tag = $match[1];
                    $existingAttributes = $match[2];
                    $content = $match[3];
    
                    // Switch tag if a new tag is provided
                    if ($newTag) {
                        $tag = $newTag;
                    }
    
                    // Process classes
                    if (!empty($class)) {
                        if (preg_match('/class\s*=\s*(["\'])(.*?)\1/', $existingAttributes, $classMatch)) {
                            // Append to existing class
                            $existingClass = $classMatch[2];
                            $existingAttributes = str_replace(
                                $classMatch[0],
                                'class="' . $existingClass . ' ' . $class . '"',
                                $existingAttributes
                            );
                        } else {
                            // Add class if it doesn't exist
                            $existingAttributes .= ' class="' . $class . '"';
                        }
                    }
    
                    // Process styles
                    if (!empty($styles)) {
                        $inlineStyles = implode('; ', $styles);
                        if (preg_match('/style\s*=\s*(["\'])(.*?)\1/', $existingAttributes, $styleMatch)) {
                            // Append to existing styles
                            $existingStyles = $styleMatch[2];
                            $existingAttributes = str_replace(
                                $styleMatch[0],
                                'style="' . $existingStyles . '; ' . $inlineStyles . '"',
                                $existingAttributes
                            );
                        } else {
                            // Add style attribute if it doesn't exist
                            $existingAttributes .= ' style="' . $inlineStyles . '"';
                        }
                    }
    
                    // Process other custom attributes
                    foreach ($attributes as $key => $value) {
                        if (preg_match('/' . $key . '\s*=\s*(["\'])(.*?)\1/', $existingAttributes, $attrMatch)) {
                            // Append to existing attribute
                            $existingValue = $attrMatch[2];
                            $existingAttributes = str_replace(
                                $attrMatch[0],
                                $key . '="' . $existingValue . ' ' . $value . '"',
                                $existingAttributes
                            );
                        } else {
                            // Add the attribute if it doesn't exist
                            $existingAttributes .= ' ' . $key . '="' . $value . '"';
                        }
                    }
    
                    // Return the updated tag, attributes, and content
                    return "<$tag$existingAttributes>$content</$tag>";
                },
                $field->value
            );
    
            return $field;
        }
    ]
]);
