<div>
    <div class="flex items-center">
        <div class="mr-3">
            <select class="block bg-gray-200 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md"
                    name="china-province" id="china-province"></select>
        </div>
        <div class="mr-3">
            <select class="block bg-gray-200 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md"
                    name="china-city" id="china-city">
                <option value="">{{__('请选择')}}</option>
            </select>
        </div>
        <div class="mr-3">
            <select class="block bg-gray-200 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md"
                    name="china-area" id="china-area">
                <option value="">{{__('请选择')}}</option>
            </select>
        </div>
    </div>
    <div class="mt-3">
        <input type="text" name="china-street"
               value="{{$provinceSelected[3] ?? ''}}"
               placeholder="{{__('街道地址')}}"
               autocomplete="off"
               class="w-full border-gray-200 rounded bg-gray-200 px-3 py-2 focus:ring-1 focus:ring-blue-600 focus:bg-white"
               required>
    </div>
</div>

<script>
    $(function () {
        var selected = @json($provinceSelected);

        var chinaProvinceRender = function (dom, list) {
            $(dom).html('');
            $(dom).append(`<option value="">{{__('请选择')}}</option>`);

            var index = null;
            for (index in list) {
                $(dom).append(`<option value="${list[index]}">${list[index]}</option>`);
            }
        }

        // province
        chinaProvinceRender('#china-province', window.chinaProvinceMap[86]);

        var chinaProvinceCityRender = function () {
            var provinceSelected = $('#china-province').val();
            if (!provinceSelected) {
                chinaProvinceRender('#china-city', {});
                return;
            }

            var cityIndex = null;
            for (var index in window.chinaProvinceMap[86]) {
                if (window.chinaProvinceMap[86][index] === provinceSelected) {
                    cityIndex = index;
                    break;
                }
            }
            if (!cityIndex) {
                return;
            }

            // city
            chinaProvinceRender('#china-city', window.chinaProvinceMap[cityIndex]);
            chinaProvinceRender('#china-area', {});
        }

        var chinaProvinceAreaRender = function () {
            var citySelected = $('#china-city').val();
            var provinceSelected = $('#china-province').val();

            if (!provinceSelected || !citySelected) {
                chinaProvinceRender('#china-area', {});
                return;
            }

            var cityIndex = null;
            for (var index in window.chinaProvinceMap[86]) {
                if (window.chinaProvinceMap[86][index] === provinceSelected) {
                    cityIndex = index;
                    break;
                }
            }
            if (!cityIndex) {
                return;
            }

            var areaIndex = null;
            for (var index1 in window.chinaProvinceMap[cityIndex]) {
                if (window.chinaProvinceMap[cityIndex][index1] === citySelected) {
                    areaIndex = index1;
                    break;
                }
            }
            if (!areaIndex) {
                return;
            }

            // area
            chinaProvinceRender('#china-area', window.chinaProvinceMap[areaIndex]);
        }

        $('#china-province').change(function () {
            chinaProvinceCityRender();
        });

        $('#china-city').change(function () {
            chinaProvinceAreaRender();
        });

        if (selected.length > 0) {
            $('#china-province').find(`option[value="${selected[0]}"]`).attr('selected', true);
            // 渲染city
            chinaProvinceCityRender();
            if (selected.length > 1) {
                $('#china-city').find(`option[value="${selected[1]}"]`).attr('selected', true);
                // 渲染area
                chinaProvinceAreaRender();
                if (selected.length > 2) {
                    $('#china-area').find(`option[value="${selected[2]}"]`).attr('selected', true);
                }
            }
        }
    });
</script>