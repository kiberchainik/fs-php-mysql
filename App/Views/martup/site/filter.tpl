<div class="">
    <form id="filter" action="/category/filter/<?=$page?>" method="post">
    <?php if($filter): ?>
    <?php foreach($filter as $f => $val): ?>
        <?php if($val['type'] == 'select'): ?>
        <div class="filter__box">
            <label for="<?=$val['name']?><?=$v['id_value']?>"><?=$val['placeholder']?></label>
            <select name="<?=$val['name']?>" id="<?=$val['name']?><?=$v['id_value']?>">
                <option value="0">- Select -</option>
                <?php foreach($val['value'] as $v): ?>
                <option value="<?=$v['id_value']?>"><?=$v['value']?></option>
                <?php endforeach ?>
            </select>
        </div>
        <?php endif ?>
        <?php if($val['type'] == 'radio'): ?>
        <div class="filter__box input-radio">
            <h5><?=$val['placeholder']?></h5>
            <?php foreach($val['value'] as $v): ?>
            <label for="<?=$val['name']?><?=$v['id_value']?>">
            <input type="radio" name="<?=$val['name']?>" id="<?=$val['name']?><?=$v['id_value']?>" value="<?=$v['id_value']?>" /> <?=$v['value']?>
            </label>
            <?php endforeach ?>
        </div>
        <?php endif ?>
    <?php endforeach ?>
    <button class="btn btn-sm btn-radius btn-default mb-4" type="submit">Show</button>
    <a id="clearfilter" class="btn btn-sm btn-radius btn-default mb-4">Clear filter</a>
    <?php endif ?>
    </form>
</div>
<script>
(function ( $ ) {
    $.fn.FormCache = function( options ) {
        var settings = $.extend({
        }, options );
        
        function on_change(event) {
            var input = $(event.target);
            var key = input.parents('form:first').attr('name');
            var data = JSON.parse(localStorage[key]);
            
            //if(input.attr('type') == 'radio' || input.attr('type') == 'checkbox') {
                data[input.attr('name')] = input.val();
            //}
            
            localStorage[key] = JSON.stringify(data);
        }
        
        return this.each(function() {    
            var element = $(this);
            
            if(typeof(Storage)!=="undefined"){
                var key = element.attr('name');
                
                var data = false;
                if(localStorage[key]) {
                    data = JSON.parse(localStorage[key]);
                }
                
                if(!data) {
                    localStorage[key] = JSON.stringify({});
                    data = JSON.parse(localStorage[key]);
                }
                element.find('input, select').change(on_change);
                
                element.find('input, select').each(function(){
                    if($(this).attr('type') != 'submit') {
                        var input = $(this);
                        var value = data[input.attr('name')];
                        
                        if(input.attr('type') == 'radio' || input.attr('type') == 'checkbox') {
                            if(value) {
                                if (input.val() == value) {
                                    input.prop('checked', true);
                                }
                            } else {
                                input.removeAttr('checked');
                            }
                        } else {
                            input.val(value);
                        }
                    }
                });
            }
            else {
                alert('local storage is not available');
            }
        });
    };     
}( jQuery ));

$(document).ready(function(){
    $('#filter').FormCache();
});

$(document).ready(function(){
    $('#clearfilter').on('click', function(){
        localStorage.clear();
        $("#filter").trigger('reset');
    });
});
</script>