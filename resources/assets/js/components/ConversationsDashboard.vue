<template>
    <div class="row">
        <div class="col-md-5">
            <conversations></conversations>
        </div>
        <div class="col-md-7">
            <conversation :id="id"></conversation>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            'id' : {
                'default': null
            }
        }
    }
</script>
