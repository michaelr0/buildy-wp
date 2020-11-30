@extends('modules.common')

@php
//  BUTTON
$module_link_url = $bladeData->options->module_link->url ?? null;
    $module_link_new_tab = $bladeData->options->module_link->new_tab ?? null;
$buttonOneEnabled = $bladeData->content->button->buttonEnabled || $bladeData->options->buttonOneEnabled ?? null;
$buttonTwoEnabled = $bladeData->options->buttonTwoEnabled ?? null;

// var_dump($buttonOneEnabled); exit;

if ($buttonOneEnabled) {
    $buttonOneURL = (string) ($bladeData->content->button->url ?? null);
    $buttonOneText = (string) ($bladeData->content->button->text ?? null);
    $buttonOneColor = $bladeData->content->button->colour ?? null;
    $buttonOneBgColor = $bladeData->content->button->backgroundColor ?? null;
    $buttonOneBorderColor = $bladeData->content->button->borderColor ?? null;
    $buttonOneShowBG = $bladeData->content->button->showBackground ?? null;
    $buttonOneOutlined = $bladeData->content->button->outlined ?? null;
    $buttonOneUnStyled = $bladeData->content->button->unStyled ?? null;
    $buttonOneTarget = $bladeData->content->button->target ?? null;
    $buttonOneClass = $bladeData->content->button->class ?? null;
    $buttonOneSize = $bladeData->content->button->size && $bladeData->content->button->size !== 'Initial' ? $bladeData->content->button->size : false;
    if (preg_match("/^\d+$/", $buttonOneURL)) {
        $buttonOneURL = get_permalink($buttonOneURL);
    }
}

if ($buttonTwoEnabled) {
    $buttonTwoURL = (string) ($bladeData->content->buttontwo->url ?? null);
    $buttonTwoText = (string) ($bladeData->content->buttontwo->text ?? null);
    $buttonTwoColor = $bladeData->content->buttontwo->colour ?? null;
    $buttonTwoBgColor = $bladeData->content->buttontwo->backgroundColor ?? null;
    $buttonTwoBorderColor = $bladeData->content->buttontwo->borderColor ?? null;
    $buttonTwoShowBG = $bladeData->content->buttontwo->showBackground ?? null;
    $buttonTwoOutlined = $bladeData->content->buttontwo->outlined ?? null;
    $buttonTwoUnStyled = $bladeData->content->buttontwo->unStyled ?? null;
    $buttonTwoTarget = $bladeData->content->buttontwo->target ?? null;
    $buttonTwoClass = $bladeData->content->buttontwo->class ?? null;
    $buttonTwoSize = $bladeData->content->buttontwo->size && $bladeData->content->buttontwo->size !== 'Initial' ? $bladeData->content->buttontwo->size : false;
    if (preg_match("/^\d+$/", $buttonTwoURL)) {
        $buttonTwoURL = get_permalink($buttonTwoURL);
    }
}

$imageURL = (!empty($bladeData->content->image->url)) ? $bladeData->content->image->url : null;
$imageSize = (!empty($bladeData->content->image->imageSize)) ? $bladeData->content->image->imageSize : "full";
$imageID = $bladeData->content->image->imageID ?? null;

$image_id = $bladeData->content->image->id ?? null;
$image_class = $bladeData->content->image->class ?? null;


$imageWidth = !empty($bladeData->content->image->width) ? "width: {$bladeData->content->image->width};" : '';
$imageMaxWidth = !empty($bladeData->content->image->maxWidth) ? "max-width: {$bladeData->content->image->maxWidth};" : '';
$imageHeight = !empty($bladeData->content->image->height) ? "height: {$bladeData->content->image->height};" : '';
$imageMaxHeight = !empty($bladeData->content->image->maxHeight) ? "max-height: {$bladeData->content->image->maxHeight};" : '';
$imageObjectFit = !empty($bladeData->content->image->objectFit) ? "object-fit: {$bladeData->content->image->objectFit};" : '';
$imageObjectPosition = !empty($bladeData->content->image->objectPosition) ? "object-position: {$bladeData->content->image->objectPosition};" : '';
$imageTitlePosition = $bladeData->content->image->imageTitlePosition ?? 'Image Above';

// Backwards compatibility for images that are set with URL only
if ((!$imageID && $imageURL) && function_exists('attachment_url_to_postid')) {
  $imageID = attachment_url_to_postid( $imageURL );
}

@endphp

@section('content')
    @if(!empty($module_link_url))
        <a @if($module_link_new_tab) target="_blank" @endif href="{{ $module_link_url }}">
    @endif

        {{-- When the image is set above the title --}}
        @if($imageID && $imageTitlePosition === 'Image Above')
            <div class="bmcb-blurb__image-wrapper">
                @if(function_exists('wp_get_attachment_image'))
                    @php echo wp_get_attachment_image($imageID, $imageSize, "", array(
                        "class" => "bmcb-blurb__image",
                        "style" => "$imageWidth $imageMaxWidth $imageHeight $imageMaxHeight $imageObjectFit $imageObjectPosition" )); @endphp
                @else
                    <img style="{{ $width }} {{ $maxWidth }} {{ $height }} {{ $objectFit }} {{ $objectPosition }}"
                    @if($imageURL) src="{{ $imageURL }}" @endif />
                @endif
            </div>
        @endif

        <div class="bmcb-blurb__content">
            @component('modules.components.title', ['bladeData'=> $bladeData])@endcomponent

            {{-- When the image is set below the title --}}
            @if($imageID && $imageTitlePosition === 'Image Below')
                <div class="bmcb-blurb__image-wrapper">
                    @if(function_exists('wp_get_attachment_image'))
                        @php echo wp_get_attachment_image($imageID, $imageSize, "", array(
                            "id" => $image_id,
                            "class" => "bmcb-blurb__image {$image_class}",
                            "style" => "$imageWidth $imageMaxWidth $imageHeight $imageMaxHeight $imageObjectFit $imageObjectPosition" )); @endphp
                    @else
                        <img style="{{ $imageWidth }} {{ $imageMaxWidth }} {{ $imageHeight }} {{ $imageMaxHeight }} {{ $imageObjectFit }} {{ $imageObjectPosition }}"
                        @if($imageURL) src="{{ $imageURL }}" @endif />
                    @endif
                </div>
            @endif

            @if($bladeData->content->body)
                <div class="bmcb-blurb__description">{!! $bladeData->content->body !!}</div>
            @endif
            @if($buttonOneEnabled || $buttonTwoEnabled)
                <div class="bmcb-blurb__button-wrapper @if($buttonOneEnabled && $buttonTwoEnabled)button__group @endif">
                    @if($buttonOneEnabled)
                        <{{ !$module_link_url ? 'a' : 'div' }}
                        class="btn
                            @if(!$buttonOneUnStyled)
                                @if($buttonOneShowBG)
                                    bg-{{ $buttonOneBgColor }}
                                @endif
                                @if(!$buttonOneOutlined)
                                    bg-{{ $buttonOneBgColor }}
                                @else
                                    is-outlined
                                @endif
                                @if($buttonOneOutlined && $buttonOneBorderColor)
                                    border-{{ $buttonOneBorderColor }}
                                @endif
                            @else
                                btn-unstyled
                            @endif
                            @if($buttonOneColor)
                                text-{{ $buttonOneColor }}
                            @endif
                            @if($buttonOneSize)
                                btn--{{ $buttonOneSize }}
                            @endif
                            @if($buttonOneClass)
                              {{ $buttonOneClass }}
                            @endif
                            "
                        @if($buttonOneTarget)
                            target="{{ $buttonOneTarget }}"
                        @endif
                        href="{{ $buttonOneURL ? $buttonOneURL : '#' }}">{{ $buttonOneText }}</{{ !$module_link_url ? 'a' : 'div' }}>
                    @endif
                    @if($buttonTwoEnabled)
                        <{{ !$module_link_url ? 'a' : 'div' }}
                        class="btn
                            @if(!$buttonTwoUnStyled)
                                @if($buttonTwoShowBG)
                                    bg-{{ $buttonTwoBgColor }}
                                @endif
                                @if(!$buttonTwoOutlined)
                                    bg-{{ $buttonTwoBgColor }}
                                @else
                                    is-outlined
                                @endif
                                @if($buttonTwoOutlined && $buttonTwoBorderColor)
                                    border-{{ $buttonTwoBorderColor }}
                                @endif
                            @else
                                btn-unstyled
                            @endif
                            @if($buttonTwoColor)
                                text-{{ $buttonTwoColor }}
                            @endif
                            @if($buttonTwoSize)
                                btn--{{ $buttonTwoSize }}
                            @endif
                            @if($buttonTwoClass)
                              {{ $buttonTwoClass }}
                            @endif
                            "
                        @if($buttonTwoTarget)
                            target="{{ $buttonTwoTarget }}"
                        @endif
                        href="{{ $buttonTwoURL ? $buttonTwoURL : '#' }}">{{ $buttonTwoText }}</{{ !$module_link_url ? 'a' : 'div' }}>
                    @endif
                </div>
            @endif
        </div>
    @if(!empty($module_link_url))
        </a>
    @endif
@overwrite
