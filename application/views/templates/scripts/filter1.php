<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 25/02/2019
 * Time: 10:57
 */
?>
<script>
    var app = new Vue({
        el: '#filter',
        data: {
            checked: false,
            mindate: '',
            maxdate : '',
            required : '',
            parType: false,
            requiredType: false
        },
        methods: {
            fadein: function(){
                this.checked = true;
                this.required = "required";
            },
            fadein2: function(){
                this.parType = true;
                this.requiredType = "required";
            }
        }
    });
</script>
