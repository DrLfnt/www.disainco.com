<?php

return array(

    'Layout' => array(
        'elements' => array(
            'gridwrapper'  => array(
                'title' => 'Grid row (grid wrapper)',
                'code'  => '[row][/row]',
                'attributes' => array(
                    array(
                        'name'  => 'class',
                        'type'  => 'textbox',
                        'label' => 'CSS Class (Optional)',
                    ),
                )
            ),
            'grid'  => array(
                'title' => 'Grid column',
                'code'  => '[column][/column]',
                'attributes' => array(
                    array(
                        'name'  => 'size',
                        'type'  => 'slider',
                        'label' => 'Column',
                        'default' => 6,
                        'min'   => 1,
                        'max'   => 12,
                    ),
                    array(
                        'name'  => 'offset',
                        'type'  => 'slider',
                        'label' => 'Offset',
                        'default' => 0,
                        'min'   => 0,
                        'max'   => 12,
                    ),
                    array(
                        'name'  => 'class',
                        'type'  => 'textbox',
                        'label' => 'CSS Class (Optional)',
                    ),
                )
            ),
        ),
    ),

    'Formating' => array(
        'elements' => array(
            'intro'  => array(
                'title' => 'Intro',
                'code'  => '[intro]Put your intro right here...[/intro]',
                'attributes' => array(
                    array(
                        'name'  => 'class',
                        'type'  => 'textbox',
                        'label' => 'CSS Class (Optional)',
                    ),
                )
            ),
            'dropcap'  => array(
                'title' => 'Drop Cap',
                'code'  => '[dropcap][/dropcap]',
                'attributes' => array(
                    array(
                        'name'  => 'class',
                        'type'  => 'textbox',
                        'label' => 'CSS Class (Optional)',
                    ),
                )
            ),
            'pullquote'  => array(
                'title' => 'Pull Quote (block quote with align)',
                'code'  => '[pullquote][/pullquote]',
                'attributes' => array(
                    array(
                        'name'  => 'position',
                        'type'  => 'select',
                        'label' => 'Pullquote Position',
                        'default' => 'left',
                        'items' => array(
                            array(
                                'value' => 'right',
                                'label' => 'Right'
                            ),
                            array(
                                'value' => 'left',
                                'label' => 'Left'
                            ),
                        ),
                    ),
                    array(
                        'name'  => 'class',
                        'type'  => 'textbox',
                        'label' => 'CSS Class (Optional)',
                    ),
                )
            ),
            'highlight'  => array(
                'title' => 'Highlight',
                'code'  => '[highlight][/highlight]',
                'attributes' => array(
                    array(
                        'name'  => 'text_color',
                        'type'  => 'color',
                        'label' => 'Text Color',
                    ),
                    array(
                        'name'  => 'bg_color',
                        'type'  => 'color',
                        'label' => 'Background Color',
                    ),
                    array(
                        'name'  => 'class',
                        'type'  => 'textbox',
                        'label' => 'CSS Class (Optional)',
                    ),
                )
            ),
            'tooltips'  => array(
                'title' => 'Tooltip',
                'code'  => '[tooltip][/tooltip]',
                'attributes' => array(
                    array(
                        'name'  => 'text',
                        'type'  => 'textbox',
                        'label' => 'Tooltip Text',
                    ),
                    array(
                        'name'  => 'url',
                        'type'  => 'textbox',
                        'label' => 'Tooltip URL',
                    ),
                    array(
                        'name'  => 'class',
                        'type'  => 'textbox',
                        'label' => 'CSS Class (Optional)',
                    ),
                )
            ),
            'spacing'  => array(
                'title' => 'Clear Spacing',
                'code'  => '[spacing]',
                'attributes' => array(
                    array(
                        'name'  => 'size',
                        'type'  => 'slider',
                        'label' => 'Spacing Size',
                        'default' => 10,
                        'min'   => 1,
                        'max'   => 200

                    ),
                )
            ),
        )
    ),

    'Icon' => array(
        'elements' => array(
            'icon'  => array(
                'title' => 'Single Icon',
                'code'  => '[singleicon]',
                'attributes' => array(
                    array(
                        'type' => 'fontawesome',
                        'name' => 'id',
                        'label' => 'Select Icon',
                        'default' => array(
                            '{{first}}',
                        ),
                    ),
                    array(
                        'name'  => 'color',
                        'type'  => 'color',
                        'label' => 'Color',
                    ),
                    array(
                        'name'  => 'size',
                        'type'  => 'slider',
                        'label' => 'Size',
                        'default' => 1,
                        'min'   => 1,
                        'max'   => 10,
                        'step'	=> 0.1
                    ),
                )
            ),

            'iconlistwrapper'  => array(
                'title' => 'Icon List Wrapper',
                'code'  => '[iconlistwrapper]
				<br/> => insert List with Icon Here
				<br/>[/iconlistwrapper]',
            ),

            'iconlist'  => array(
                'title' => 'Icon List',
                'code'  => '[iconlist][/iconlist]',
                'attributes' => array(
                    array(
                        'type' => 'fontawesome',
                        'name' => 'id',
                        'label' => 'Select Icon',
                        'default' => array(
                            '{{first}}',
                        ),
                    ),
                    array(
                        'name'  => 'color',
                        'type'  => 'color',
                        'label' => 'Icon Color',
                    ),
                    array(
                        'name'  => 'spin',
                        'type'  => 'toggle',
                        'label' => 'Spin Icon',
                    ),
                )
            ),

        ),
    ),

    'Element' => array(
        'elements'=> array(
            'googlemap'  => array(
                'title' => 'Google Maps',
                'code'  => '[googlemap][/googlemap]',
                'attributes' => array(
                    array(
                        'name'  => 'title',
                        'type'  => 'textbox',
                        'label' => 'Map Title',
                    ),
                    array(
                        'name'  => 'lat',
                        'type'  => 'textbox',
                        'label' => 'Latitude',
                    ),
                    array(
                        'name'  => 'lng',
                        'type'  => 'textbox',
                        'label' => 'Longitude',
                    ),
                    array(
                        'name'  => 'zoom',
                        'type'  => 'slider',
                        'label' => 'Map Zoom',
                        'default' => 14,
                        'min'   => 1,
                        'max'   => 21,
                    ),
                    array(
                        'name'  => 'ratio',
                        'type'  => 'slider',
                        'label' => 'Map Ratio',
                        'default' => 0.5,
                        'min'   => 0.1,
                        'max'   => 2,
                        'step'	=> 0.1
                    ),
                    array(
                        'name'  => 'popup',
                        'type'  => 'toggle',
                        'label' => 'Show popup',
                    ),
                    array(
                        'name'  => 'class',
                        'type'  => 'textbox',
                        'label' => 'CSS Class (Optional)',
                    ),
                )
            ),
            'alert'  => array(
                'title' => 'Alert',
                'code'  => '[alert]',
                'attributes' => array(
                    array(
                        'name'  => 'type',
                        'type'  => 'select',
                        'label' => 'Alert Type',
                        'default' => 'success',
                        'items' => array(
                            array(
                                'value' => 'success',
                                'label' => 'Success'
                            ),
                            array(
                                'value' => 'info',
                                'label' => 'Info'
                            ),
                            array(
                                'value' => 'warning',
                                'label' => 'Warning'
                            ),
                            array(
                                'value' => 'danger',
                                'label' => 'Danger'
                            ),
                        ),
                    ),
                    array(
                        'name'  => 'main_text',
                        'type'  => 'textbox',
                        'label' => 'Main Text'
                    ),
                    array(
                        'name'  => 'second_text',
                        'type'  => 'textbox',
                        'label' => 'Second Text',
                    ),
                    array(
                        'name'  => 'show_close',
                        'type'  => 'toggle',
                        'label' => 'Show Close Button',
                    ),
                    array(
                        'name'  => 'class',
                        'type'  => 'textbox',
                        'label' => 'CSS Class (Optional)',
                    ),
                ),
            ),
            'button'  => array(
                'title' => ' Button',
                'code'  => '[button]',
                'attributes' => array(
                    array(
                        'name'  => 'type',
                        'type'  => 'select',
                        'label' => 'Button Type',
                        'default' => 'default',
                        'items' => array(
                            array(
                                'value' => 'default',
                                'label' => 'Default'
                            ),
                            array(
                                'value' => 'primary',
                                'label' => 'Primary'
                            ),
                            array(
                                'value' => 'success',
                                'label' => 'Success'
                            ),
                            array(
                                'value' => 'info',
                                'label' => 'Info'
                            ),
                            array(
                                'value' => 'warning',
                                'label' => 'Warning'
                            ),
                            array(
                                'value' => 'danger',
                                'label' => 'Danger'
                            ),
                        ),
                    ),
                    array(
                        'name'  => 'text',
                        'type'  => 'textbox',
                        'label' => 'Button Text'
                    ),
                    array(
                        'name'  => 'url',
                        'type'  => 'textbox',
                        'label' => 'Button URL',
                        'default' => '#',
                    ),
                    array(
                        'name'  => 'open_new_tab',
                        'type'  => 'toggle',
                        'label' => 'Open on new tab',
                    ),
                    array(
                        'name'  => 'class',
                        'type'  => 'textbox',
                        'label' => 'CSS Class (Optional)',
                    ),
                ),
            ),

        ),
    ),

    'Accordion' => array(
        'elements' => array(
            'example'  => array(
                'title' => 'Example',
                'code'  => "[accordion]
					<br/>[accordion-element title='First Accordion' collapsed='true']
					<br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec posuere aliquam vestibulum. Aenean id feugiat tortor, faucibus posuere ante. Aliquam ornare diam quis sem consequat, ac consequat massa pretium. Phasellus ac nisl vel libero tempor hendrerit et vel magna. Pellentesque semper, velit id bibendum pharetra, justo urna aliquam turpis, vel consectetur sapien odio id erat. Aenean dolor elit, elementum quis feugiat mattis, vehicula in arcu. Etiam pellentesque rhoncus risus vel elementum. Nam aliquam sagittis elementum.
					<br/>[/accordion-element]
					<br/>[accordion-element title='Second Accordion' collapsed='false']
					<br/>Praesent luctus mattis mi, ut condimentum neque cursus sed. Etiam at metus vel odio porttitor condimentum nec ut erat. Pellentesque semper elit et metus tempus, dictum consectetur diam congue. In cursus, augue non dignissim ullamcorper, purus lorem blandit leo, ut facilisis tellus tortor tincidunt nibh. Pellentesque ullamcorper posuere orci, vitae interdum tellus pellentesque ut. Integer eu ipsum sit amet sem lobortis volutpat eu mollis dui. Curabitur nec tortor vitae sapien auctor commodo. Praesent ut eros sed est fermentum consectetur. Ut quis quam ut lacus varius rutrum. Nullam scelerisque sodales lacinia.
					<br/>[/accordion-element]
					<br/>[/accordion]",
            ),
            'accordion'  => array(
                'title' => 'Wrapper',
                'code'  => "[accordion]<br/>->> Replace this text with accordion content shortcode<br/>[/accordion]",
                'attributes' => array(
                    array(
                        'name'  => 'class',
                        'type'  => 'textbox',
                        'label' => 'CSS Class (Optional)',
                    ),
                )
            ),
            'accordioncontent'  => array(
                'title' => 'Content',
                'code'  => "[accordion-element]Enter your content here[/accordion-element]",
                'attributes' => array(
                    array(
                        'name'  => 'title',
                        'type'  => 'textbox',
                        'label' => 'Accordion Title'
                    ),
                    array(
                        'name'  => 'collapsed',
                        'type'  => 'toggle',
                        'label' => 'Collapse Accordion',
                    ),
                    array(
                        'name'  => 'class',
                        'type'  => 'textbox',
                        'label' => 'CSS Class (Optional)',
                    ),
                ),
            ),

        )
    ),

    'Tabbing' => array(
        'elements' => array(
            'example'  => array(
                'title' => 'Example',
                'code'  => "[tab-heading-wrapper]
					<br/>[tab-heading id='firstid' title='First Tab' active='true']
					<br/>[tab-heading id='secondid' title='Second Tab' active='false']
					<br/>[/tab-heading-wrapper]
					<br/>
					<br/>[tab-content-wrapper]
					<br/>[tab-content id='firstid' active='true']Praesent luctus mattis mi, ut condimentum neque cursus sed. Etiam at metus vel odio porttitor condimentum nec ut erat. Pellentesque semper elit et metus tempus, dictum consectetur diam congue. In cursus, augue non dignissim ullamcorper, purus lorem blandit leo, ut facilisis tellus tortor tincidunt nibh. Pellentesque ullamcorper posuere orci, vitae interdum tellus pellentesque ut. Integer eu ipsum sit amet sem lobortis volutpat eu mollis dui. Curabitur nec tortor vitae sapien auctor commodo. Praesent ut eros sed est fermentum consectetur. Ut quis quam ut lacus varius rutrum. Nullam scelerisque sodales lacinia.[/tab-content]
					<br/>[tab-content id='secondid' active='false']Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec ut libero at ante cursus congue. Praesent vitae tellus mauris. Nullam at iaculis quam. Aenean justo ipsum, convallis ut dui non, accumsan elementum diam. Vivamus vestibulum pretium adipiscing. Aliquam molestie, elit eget ultricies facilisis, elit neque lacinia purus, sit amet vulputate justo dui et nunc. Nam vehicula turpis odio, ut bibendum enim blandit eget. Phasellus sit amet dolor a leo placerat mollis sed sit amet sem.[/tab-content]
					<br/>[/tab-content-wrapper]",
            ),
            'tabheadingwrapper'  => array(
                'title' => 'Heading Wrapper',
                'code'  => '[tab-heading-wrapper]<br/>-->> Replace this content with tab heading shortcode<br/>[/tab-heading-wrapper]',
                'attributes' => array(
                    array(
                        'name'  => 'class',
                        'type'  => 'textbox',
                        'label' => 'CSS Class (Optional)',
                    ),
                ),
            ),
            'tabheading'  => array(
                'title' => 'Heading Content',
                'code'  => '[tab-heading]',
                'attributes' => array(
                    array(
                        'name'  => 'id',
                        'type'  => 'textbox',
                        'label' => 'Tab Unique ID',
                    ),
                    array(
                        'name'  => 'title',
                        'type'  => 'textbox',
                        'label' => 'Tab Text',
                    ),
                    array(
                        'name'  => 'active',
                        'type'  => 'toggle',
                        'label' => 'This tab is currently active',
                    ),
                )
            ),
            'tabcontentwrapper'  => array(
                'title' => 'Content Wrapper',
                'code'  => '[tab-content-wrapper]<br/>-->> Replace this content with tab content shortcode<br/>[/tab-content-wrapper]',
                'attributes' => array(
                    array(
                        'name'  => 'class',
                        'type'  => 'textbox',
                        'label' => 'CSS Class (Optional)',
                    ),
                ),
            ),
            'tabcontent'  => array(
                'title' => 'Content',
                'code'  => '[tab-content]Enter your content here[/tab-content]',
                'attributes' => array(
                    array(
                        'name'  => 'id',
                        'type'  => 'textbox',
                        'label' => 'Tab Unique ID',
                    ),
                    array(
                        'name'  => 'active',
                        'type'  => 'toggle',
                        'label' => 'This tab is currently active',
                    ),
                )
            ),
        )
    ),

);

/**
 * EOF
 */