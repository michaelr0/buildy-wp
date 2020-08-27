@if(!empty($bladeData->content->id))
    {{--
      $bladeData->id
      $bladeData->type
      $bladeData->content
      $bladeData->content->id
      $bladeData->content->options
      $bladeData->content->options->isEditable
      $bladeData->content->options->admin_label
      $bladeData->content->attributes
      $bladeData->content->attributes->id
      $bladeData->content->attributes->class
      $bladeData->content->generatedAttributes
      $bladeData->content->generatedAttributes->columns
      $bladeData->content->generatedAttributes->spacing
    --}}

    <div class="{{ $moduleClasses = $bladeData->attributes->class ?: '' }}">
      {!! $buildy->renderFrontend($bladeData->content->id) !!}
    </div>
@endif
