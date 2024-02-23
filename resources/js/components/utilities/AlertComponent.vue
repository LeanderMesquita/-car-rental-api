<template>
    <div :class="alertStyle" role="alert">
        {{title}}
        <hr>
        <span v-if="details.data.message"> {{ details.data.message }}</span>
        <span v-if="details.data.id"> {{ "ID do registro: "+details.data.id }}</span>
        <br>
        <ul v-if="details.data.errors">
            <li v-for="i, key in details.data.errors" :key="key">{{ i[0] }}</li>
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