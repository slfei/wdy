//
//    function move(arr, index1, index2){
//        arr[index1] = arr.splice(index2, 1, arr[index1])[0];
//        return arr;
//    };
//    function moveUp($index,arr){
//        if($index == 0) {
//            return;
//        }
//        move(arr, $index, $index - 1);
//    };
//    function moveDown($index,arr){
//        if($index == arr.length -1) {
//            return;
//        }
//        move(arr, $index, $index + 1);
//    }
//
//export {move,moveUp,moveDown}

export default {
    methods:{
        move(arr, index1, index2){
            arr[index1] = arr.splice(index2, 1, arr[index1])[0];
            return arr;
        },
        moveUp($index,arr){
            if($index == 0) {
                return;
            }
            this.move(arr, $index, $index - 1);
        },
        moveDown($index,arr){
            if($index == arr.length -1) {
                return;
            }
            this.move(arr, $index, $index + 1);
        }
    }
}
