<template>
    <div class="card mt-5 mb-3">
        <div class="card-header">{{title}}</div>

        <div class="card-body">
            <slot name="content"></slot>
        </div>
        <div  class="card-footer d-flex justify-content-end">
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<script>
    export default{
        props:['title']
    }
</script>