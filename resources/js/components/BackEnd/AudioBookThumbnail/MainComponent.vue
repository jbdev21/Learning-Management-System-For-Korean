<template>
    <div>
        <div class="nav-tabs-custom">
            <input type="hidden" name="thumbnail_source_type" v-model="thumbnail_source_type">

            <ul class="nav nav-tabs">
              <li :class="{active : isUploadedTab }"><a href="#uploaded" @click.prevent="thumbnail_source_type = 'uploaded'">Uploaded</a></li>
              <li :class="{active : !isUploadedTab }"><a href="#link"  @click.prevent="thumbnail_source_type = 'link'">Link</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane" :class="{active : isUploadedTab}" id="uploaded">
                    <label for="input-thumbnail-file" class='btn btn-default btn-xs'>Change Thumbnail</label>
                    <input type="file" id="input-thumbnail-file" style="display:none;" name="thumbnail">
                    <div class="mt-2 p-3">
                        <img :src="uploadedImage" class="img img-responsive" style="max-width: 300px;" alt="">
                    </div>
                </div>
                <div class="tab-pane" :class="{active : !isUploadedTab }" id="link">
                    <input type="url" :required="!isUploadedTab" placeholder=" Link of thumbnail" v-model='linkImage' class="form-control" name="link">
                    <div class="mt-2  p-3">
                        <img :src="linkImage" class="img img-responsive" style="max-width: 300px;" alt="">
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
export default {
    props:['sourceType', 'source'],
    data(){
        return {
            thumbnail_source: this.source,
            thumbnail_source_type: this.sourceType,
            linkImage: this.sourceType == 'link' ? this.source : '',
            uploadedImage: this.sourceType == 'uploaded' ? this.source : '',  
        }
    },
    computed:{
        isUploadedTab(){
            return this.thumbnail_source_type == "uploaded";
        }
    }
}
</script>