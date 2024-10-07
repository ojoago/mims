
export function formatError() {
    function transformValidationErrors(response , handleType = 'axios'){
        const errors = []
        if(handleType == 'axios'){
            if(response){
                for (let key in response) {
                    if(key.indexOf('.') !== -1){
                        let k = trimKey(key);
                        errors[k] = response[key][0]
                    }else{
                        errors[key] = response[key][0]
                    }
                    errors[key] = response[key][0]
                }
            }
        }
        return errors
    }
    
    function trimKey(key){
        const parts = key.split('.').filter(part => (part));
        const part = key.split('.').filter(part => !isNaN(part));
       
        // const numericValues = parts.map(Number);
        return parts[2]+part.map(Number);

// console.log(numericValues);
    }

    return {
        transformValidationErrors
    }
}