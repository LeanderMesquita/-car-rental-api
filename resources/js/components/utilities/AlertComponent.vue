<template>
    <div :class="alertStyle" role="alert">
        {{title}}
        <hr>
        <p>{{ details.message }}</p>
        <br>
        <ul v-if="details.info">
            <li v-for="i, key in details.info" :key="key">{{ i[0] }}</li>
        </ul>
        
    </div>
</template>

<script>
    export default{
        props: ['type', 'title', 'details'],
        computed: {
            alertStyle(){
                return 'alert alert-'+this.type;
            }
        }
    }
</script>