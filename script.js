async function download_img($url, $fname=""){
    const _image = await fetch($url);

    const blob = await _image.blob();
    const url = window.URL.createObjectURL(blob);

    const link = document.createElement("a");
    link.href = url;
    link.download = $fname;
    link.click();
}
$(document).ready(function(){
    $('.media-item').click(function(e){
        e.preventDefault()

        var prevModal = $('#media-preview')
        var key = $(this)[0].dataset.key;
        var fname = $(this)[0].dataset.filename;
        prevModal.find('#preview-media').html(`
            <img src="${__stacked[key]['src']['large']}" />
        `)
        prevModal.find('#phtotographer').text(`${__stacked[key]['photographer']}`)
        var dlContainer = $('#downloads')
        dlContainer.html('')
        var sizes = {
            original: "Original",
            large2x: "2x Larger",
            large: "Large",
            medium: "Medium",
            small: "Small",
            portrait: "Portrait",
            landscape: "Landscape",
            tiny: "Tiny"
        };
        Object.keys(__stacked[key]['src']).forEach(k=>{
            var _url = __stacked[key]['src'][k]
            var dlItem = $(`<a class="btn btn-sm btn-primary d-block rounded-pill mb-2 download-item" href="${_url}"><strong>${sizes[k]}</strong></a>`);
            dlContainer.append(dlItem)
            dlItem.click(function(e){{
                e.preventDefault()
                download_img(_url, fname)
            }})
        })
        prevModal.modal('show')
    })

    $('#search').on('keypress', function(e){
        // e.preventDefault()
        // console.log(e)
        if(e.which == 13 || e.keyCode == 13 || e.key == "Enter" ){
            console.log('enter')
            var uri = new URL(location.href)
            var searchParams = uri.searchParams
            if(searchParams.has('search'))
                searchParams.delete('search');
            searchParams.set('search', $(this).val())
        }
        location.href = uri.toString()
    })
})
