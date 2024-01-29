<template>
    <div class="form-group">
        <label :for="id" class="form-label">{{ title }}</label>
        <slot></slot>
        <div :id="IDhelper" class="form-text">{{ helper }}</div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'title', 'IDhelper', 'helper']
    }
</script>
