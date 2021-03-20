
function deletePic(image) {
    return fetch('http://127.0.0.1:5000/image'+image, {
        method: 'DELETE'
    }).then(() => setStatus('Delete successful'))
    .catch(error => error);
}




// deletePic((serviceURL) => {
//     fetch('serviceURL', {method: 'DELETE'})
//     .then(() => setStatus('Delete successful'));
        
// }, []);