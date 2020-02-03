const HOST_NAME = 'testphp';


class Url{
    
    static to(routeStr){
        let routes = routeStr.split('/');
        return `http://${HOST_NAME}/index.php?r=${routes[0]}/${routes[1]}`;
    } 
}
 




