<div v-if="(() => { 
    // init unset data.
    if (!data.style) {
        data.style = '';
    } 
})()">
</div>
<label class='grid-info-120' v-tooltip='"Adds class to image"'>
    <span>Image Class</span>
    <input v-model='data.class' class='form-control'>
</label>

<label class='grid-info-120' v-tooltip='"Image size to use"'>
    <span>Image Size</span>
    <input v-model='data.size' class='form-control'>
</label>

<label class='grid-info-120' v-tooltip='"Fallback url to use when product has no set image"'>
    <span>Fallback Image</span>
    <input v-model='data.fallback' class='form-control'>
</label>

<label class='grid columns-1 gap-2' v-tooltip='"Image style property"'>
    <span>Image Style</span>
    <pockets-ux-code-editor 
        v-model='data.style'
    ></pockets-ux-code-editor>
</label>