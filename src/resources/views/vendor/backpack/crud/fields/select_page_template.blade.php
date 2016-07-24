<!-- Select template field. Used in Backpack/PageManager to redirect to a form with different fields if the template changes. A fork of the select_from_array field with an extra ID and an extra javascript file. -->
  <div @include('crud::inc.field_wrapper_attributes') >

    <label>{{ $field['label'] }}</label>
    <select
    	class="form-control"
        id="select_template"

    	@foreach ($field as $attribute => $value)
            @if (!is_array($value))
    		{{ $attribute }}="{{ $value }}"
            @endif
    	@endforeach
    	>

        @if (isset($field['allows_null']) && $field['allows_null']==true)
            <option value="">-</option>
        @endif

    	@if (count($field['options']))
    		@foreach ($field['options'] as $key => $value)
    			<option value="{{ $key }}"
					@if (isset($field['value']) && $key==$field['value'])
						 selected
					@endif
    			>{{ $value }}</option>
    		@endforeach
    	@endif
	</select>

    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
  </div>


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- select_template crud field JS -->
        <script>
            function redirect_to_new_page_with_template_parameter() {
                var new_template = $("#select_template").val();
                var current_url = "{{ Request::url() }}";

                window.location.href = strip_last_template_parameter(current_url)+'/'+new_template;
            }

            function strip_last_template_parameter(url) {
                // if it's a create or edit link with a template parameter
                if (url.indexOf("/create/") > -1 || url.indexOf("/edit/") > -1)
                {
                    // remove the last parameter of the url
                    var url_array = url.split('/');
                    url_array = url_array.slice(0, -1);
                    var clean_url = url_array.join('/');

                    return clean_url;
                }

                return url;
            }

            jQuery(document).ready(function($) {
                $("#select_template").change(function(e) {
                    var select_template_confirmation = confirm("Are you sure you want to change the page template? You will lose any unsaved modifications for this page.");
                    if (select_template_confirmation == true) {
                        redirect_to_new_page_with_template_parameter();
                    } else {
                        // txt = "You pressed Cancel!";
                    }
                });

            });
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}