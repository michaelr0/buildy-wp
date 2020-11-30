 @php

$atts = $bladeData->attributes ?? null;

if (!empty($atts)) {
  $moduleID = $bladeData->attributes->id ?? null;
  $moduleClasses = $bladeData->attributes->class ?? null;
  $dataAtts = $bladeData->attributes->data ?? null;
  $internalLinkEnabled = $bladeData->attributes->in_page_link_enabled ?? null;
  $internalLinkText = $bladeData->attributes->in_page_link_text ?? null;
}

$options = $bladeData->options ?? null;
$moduleStyle = $options ? $bladeData->options->moduleStyle : null;

if ($moduleStyle && $moduleStyle !== 'none') {
  $moduleStyle = strtolower(preg_replace("/\s+/", "-", $moduleStyle));
  $moduleClasses .= " module-style__$moduleStyle";
}

$dataAttString = null;

// Add data atts to a string
if (isset($dataAtts)) {
  foreach($dataAtts as $dataAtt) {
    $name = strtolower($dataAtt->name);
    $value = stripslashes($dataAtt->value);
    $dataAttString .= " data-{$name}='{$value}' ";
  }
}

$inline = $bladeData->inline ?? null;

if (!empty($inline)) {
  $colors = $bladeData->inline->color ?? null;
  $textAlign = $bladeData->inline->textAlign ?? null;
}


// Temporary large/small version of text align, I'll loop this eventually
if ($textAlign) {
    foreach($textAlign as $bp=>$val) {
        if (!empty($val)) {
            if ($bp === 'xs') {
                $moduleClasses ? $moduleClasses .= " text-$val" : $moduleClasses = "text-$val";
            } else {
                $moduleClasses ? $moduleClasses .= " $bp:text-$val" : $moduleClasses = "$bp:text-$val";
            }
        }
    }
}

$moduleType = str_replace("-module", '', $bladeData->type);
$internalLinkTarget = $internalLinkText ? preg_replace("/\W|_/",'',$internalLinkText) : null;
$spacing = $bladeData->generatedAttributes->spacing ?? null;

/* Add responsive margin/padding classes if they're set */
if ($spacing) {
    $moduleClasses ? $moduleClasses .= " $spacing" : $moduleClasses = $spacing;
}

if ($colors) {
    forEach($colors as $key=>$val) {
        if (strtolower($val) !== 'none') {
            if ($key !== 'xs') {
                $moduleClasses ? $moduleClasses .= " $key:text-$val" : $moduleClasses = "$key:text-$val";
            } else {
                $moduleClasses ? $moduleClasses .= " text-$val" : $moduleClasses = "text-$val";
            }
        }
    }
}

 @endphp
<div
    {{-- If ID is set --}}
    @if($moduleID) id="{{ $moduleID }}" @endif

    {{-- If Internal Link is set (override ID) --}}
    @if($internalLinkEnabled)
        id="{{ $internalLinkTarget }}"
        data-internal_link_enabled="true"
        @if($internalLinkText)
            data-internal_link_text="{{ $internalLinkText }}"
        @endif
    @endif

    @if($options ? $bladeData->options->isToggle : null)
    data-isToggle
    @endif

    {{-- Classes --}}
    class="bmcb-{{ $moduleType }} bmcb-module {{ $moduleClasses ? $moduleClasses : '' }}
    @yield('class')"

    {{-- Data Attributes --}}
    @if($dataAttString)
      {!! $dataAttString !!}
    @endif>
    @yield('content')
</div>
