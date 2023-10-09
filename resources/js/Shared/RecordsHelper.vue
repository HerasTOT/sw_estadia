<template>
    <div class="row d-flex flex-row justify-content-center" v-if="! thereAreResults || loadingResults">
        <div class="col-12" :class="{'card card-light card-body' : cardStyle}">
            <div v-if="loadingResults" class="text-center">
                <div class="spinner-border text-info" role="status">
                    <span class="sr-only"></span>
                </div>
                <h3 class="text-center">
                    Cargando resultados.<br>
                    <span class="text-sm">
                        <i class="bi bi-info-circle"></i>
                        Por favor espere
                    </span>
                </h3>
            </div>
            <div v-if=" ! loadingResults && ! thereAreResults">
                <h3 class="text-center">
                    <i class="bi bi-braces"></i><br>
                    Sin resultados encontrados.<br>
                    <span class="text-sm">
                        <i class="bi bi-info-circle"></i>
                        Si cree que es un problema, consulte al administrador del sistema.
                    </span>
                </h3>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props : {
        cardStyle : {
            type     : Boolean,
            default  : true,
            required : false
        },
        thereAreResults : {
            type     : Boolean,
            default  : false,
            required : true
        },
        loadingResults : {
            type     : Boolean,
            default  : false,
            required : true
        }
    }
}
</script>
<style scoped>

</style>
