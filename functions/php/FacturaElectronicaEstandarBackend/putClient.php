<?php 
include 'api.php'; 
include 'params.php'; 

if(isset($_POST['dv'])){
    $nit = $_POST['nit'];
    $dv = $_POST['dv'];
    $tipodi = $_POST['tipodi'];
    $tipoorg = $_POST['tipoorg'];
    $tiporeg = $_POST['tiporeg'];
    $tipores = $_POST['tipores'];
    $razon = $_POST['razon'];
    $rm = $_POST['rm'];
    $municipio = $_POST['municipio'];
    $dir = $_POST['dir'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];




    $url = 'https://backend.estrateg.com/API/public/api/ubl2.1/config/'.$nit.'/'.$dv.'';
    $metodo = 'POST'; 
    $datos = array(
        'type_document_identification_id'=> $tipodi,
        'type_organization_id'=> $tipoorg,
        'type_regime_id'=> $tipoorg,
        'type_liability_id'=> $tipores,
        'business_name'=> $razon,
        'merchant_registration'=> $rm,
        'municipality_id'=> $municipio,
        'address'=> $dir,
        'phone'=> $tel,
        'email'=> $email,
        'mail_password'=> 'Tg@820715',
        'mail_host'=> 'mail.hotmail.es',
        'mail_port'=> '548',
        'mail_username'=> 'LOIDASC9@HOTMAIL.COM',
        'mail_encryption'=> 'md5'
    );

    

    $result = llamarApi($url,$metodo,$datos,$bearer);

    //echo $result;

    $data =  json_decode($result,true);

    if( isset($data["success"])){
        echo $data["message"]."<br>";
        //echo $data["token"];
    }else{
        echo $data;
        echo "Dato con errores favor verificar";
    }
}





if(isset($_POST['id'])){
    $id = $_POST['id'];
    $pin = $_POST['pin'];
    $nit = $_POST['nit'];


    $url = 'https://backend.estrateg.com/API/public/api/ubl2.1/config/software';
    $metodo = 'PUT'; 
    $datos = array(
        'id'=> $id,
        'pin'=> $pin
    );
    //$autorizacion = '5de658704d41e7f34cdb752ed5d3379301b9fabcc7604b894904b3953b1bfeec';

    
    $bearer = ValidarBearer($nit);

    $result = llamarApi($url,$metodo,$datos,$bearer);

    //echo $result;

    $data =  json_decode($result,true);

    if( isset($data["success"])){
        echo $data["message"];
    }else{
        echo "Dato con errores favor verificar<br>";
        echo $data["message"];
    }
}

/*
PROCESO ANTERIOR -- HACE EL PROCESO PERO NO ENVIA EL CERTIFICADO

if(isset($_POST['certificado'])){
    //$certificado = $_POST['certificado'];
    //$password = $_POST['password'];

    $payload= array('certificate'=>$_POST['certificado'],'password'=>$_POST['password']);
    $payload = json_encode($payload);

    //$certificado ="MIIcWgIBAzCCHCAGCSqGSIb3DQEHAaCCHBEEghwNMIIcCTCCFo8GCSqGSIb3DQEHBqCCFoAwghZ8AgEAMIIWdQYJKoZIhvcNAQcBMBwGCiqGSIb3DQEMAQYwDgQIv1Pt3c0ljGMCAggAgIIWSD3FxlRA8J5Ue1fiHRr9pP0+ukRhg1YY6k8/t4djScIhVMWz/d3GE4HItmsVQyRSbQtsnaBx3Z2Zp19EP+2kOIL93JS2xbHbseEMbIA/4Jk4DT9tqBQLxw6QuoEMSanEu/qDawk2Zen0GjqbbkBiLv3K0OnPWqClELmtEGmfT86LQ1NMQqRylUpbB5d20kxmrUzfPHwqDrC1+heV+HiV+lJ31hUM3weVbD7/nw7xyB/f9JIePhs6fGqoouV3Y5J6imt6Ck/+rCDkwt5e1aQUJdY1USzfUFCn+QvLounZbdzYX+r3F65AOL/d65s1zP7vK08B03M7DNe4qK1UX6RZmrHR12nqz6pSQ4nBHnyaDqPv0hdlt2q2QRQKwNaQoALvgGJVzcN9R775oabTHvadLDiY9alm0CYt5gKX5kiRYHktoJRVAcw0seZyh37E+P1IBb+IHHShSylBpK/eC7TstavX+7I+Eo0qoAoWZWJN4VWYJTQME8cVSJBGsHIA2UeI3ResnoutxM8qKxnyqRMgd6kcjt19bjGmJYHv4UAWm/I8IOhfgm5HTMixC3gD8l9Vri0QjHrBzRE/UO2Aj5yko49X67HMUSsX9DD7fTm/+lyJSPv60gzJWvgXiZ0V0f7vA/O/E07GA/gU3Oc7HNHQSxHZ+6EWzduVIIyCQzab4MLGhH+mYP9MnhNYhYJP++8l822gdkOt1vH6RDH7H7FtD7hxviRCZZak5G0YzoM9pFaig2t50xq4SFi3TFWCLpeXWM/AAWGhqThKos8/yAF6LbIZq5rLpgTjNa8M+xZg+CPO7FBMVljts4LUz+06GqubtNW+0zdEw/3uI3hndvolCPmp1aE23Dzco0nirgMyHSNfpJWRd+NwNg7B9kBcsIMi6xgWpF83r4HYJAdg+vorLqvfmBfiSoOQYgXM1UckrJPEy1iIuWYDaSWM4Mh2XGad35t8kWL5Q/Nv1oatpbgmfjajMh9lnb1sOZJdwi66bSd6ToK1Kpe4SSOv5vG9FgqzEX5y/DoFZjNZQetuUp6KW/iUPOseD9y4ZMVdbU/lOcwt2kqXe8BvY0qiFLAv4ftP/7cOXD3WZEqweY5lu5d1UK4xQk3Vrlf9y+ecqQgMU99siCud/nT/a3I/QrYAJXZlhyQvw2urG8SZrxVzyb+HNGuvtseGrn93SWj78gcYu7aWPoOty74jjSUPhQ6NUVDn4RrRtvEcBuRWZAX1PSHuDCsAJtBkGeKWbU6rseaLTclFwTRqsRLB8ztELlLS3FnMq5DaHEFhDW6YnZxj8+/KlUMGoETU9uOXfqKDx3+1ivFhnWjvh7n3f+kvM8o0NghEbRL6XWYKPHenv8HjF2WT9xUBPPJ1M3MpsCV0736zKiSAaJ89+CrLQEOQ3CpdHfxPFkyIOfmUgPYsN4c/3KMKBqSztJnwcLF2yVubevZu+fnmqSCwAsN1DU9lnDKVkSwo2zwzzShJdGjRoUz5yofvNUuMaSi41GkTzaRrzz1AKrWkRQFdnQL9Z0ZsWlgnvv1VTgblSw5zYC9ZYOFC1X0jjGbBKdLNxhik9MWvp/+RABTTdh3qoZAJtLFIN9MZTisrrBverkL0DaJlrrSONbJZjZKYxLqIxyXaLHBR5qsw/RY+ZgCrS6JsJrd9AH3pP7XgkpOSLWnOrshNPhDicVKxpEa14oE24EC75NijT+yetRQpsILFUSZ0UMOmsIjsXpQZEQp1zJw/2gNtfBFmZvF8HboewA2uoITmMMNeyKN0CoqDa+kewrSluE5roMN1RGeRnL0iR6qZnQJ7wKn6VjxSKg5DizkO4DuvZhALDKxAWaGt6LOXdv3iZvtFHnsGeghtVneS0oIy8Z8wuXOQuPRWjTAKg6qXrWxFz/izNIcgteGQLzxiQ7Ua4KJjmAPoLEnRXtwdEUorwLVIciSuOYI/Y75j0CP68ixQd7PM+VrAG9J4aRSRG9NAEY9T21OyMkYATlRsC8LQjYPhNPZnrnxdvb9AYIl/shH1H682kMsJwKXw57PIq+Q1XmGqdFWs4RZPeVG/o/xHut6J2xPLeOUBs8hVb6jQZ2PHGgnelZC97w11dJk0cqGwSdLOYnCFZnMyWSbZ/lelDTIgZrhXuxJnN+PnmofM/k9oqBU/Pw1K1O3bKo5FYedU6u/UXVK9t3xAr08fAu3m9I2uSIRYRNJs4bBkCxpY5ao2bBi5LEidyGTGCSJh9Ldniy706jfay1EVJBLhoDMM5x3bWkPpLN5K+IQBwkOePzu1+zwF1EyQ53b4enW7vmCdAuG7KbC4od1uxqgpb2Ft5pggxOiyspWGmDiatVejlx7PML8yM43bv1ZHwAQKzBkzPZWQR/Qf25Pt1C90/pmuLC02Cbo1WBb8lzvD6ICIcAROt9gHH2So1ehrqFTx/7+Kv12e5AH6XweZbuaYqnk54yO4FLRCXD8nE6F4Hy79d18mhMGLlZ/UugX4+cXCIuWJko0PgnZr0KlREBA4nDnJPhR5bn/frUzfmHo/lkLg26DyiN2wUAySaGAJFwKNmmwLc+sz6UIFqROqZbvx12I8eCSce33OMTSc2ti6a/u/SIFXu/PJqF/bPF10Em0IEkxdvmCVe45GVhdflSn6xH6lzVbzXSUxmvYKFeeEZHDNh05i1l8/en49DQt9oaMn6OJ5ZAplGxp7+luvcR1paqDif/FR9haF6bPWqu1DRcprT/GAA3BySw7A6uIgV8KjC94suQovKjWldPCnKss7Z1PUnbz11Z1rxQ9WuOjcYXM4tQ/x9T7wQXqP5vdMfiv0AGtYrJGydMSru85cg5sBVmhvfugN3avqO24n2qdXQK2oBt0wEE5daubAzEbQXuqeIB+SAZDr7zqe7ERRee2/E0fWDW3dpQ0HTf2rBBcyH4T96UnvFBMI0NnsSxipK3KSYpB9GmuL3LB2GVUTghY51UsA0djZ23uzM/aLjf+x7cfDg0d8W4hwe3X3l1nY7iecoc92KpoX0Cd2cusaj73MxQoYf0eVPkljaTSD0+W1/TeWHhBxZ+iuqh1wGn+hGDzhii+ietfmYlaq07+dzp5Z0yEPBJAiVwmKy7WsFOIyUEQexJwL7Rdef6UycLLZ5RagImgpUL+VoocXimWs63gK1SQn0x2N4DNWAuZ2Qs4siiLANeeFxBGfY0TEPoFCf4QHQPUHzL8JYOzvDr83rtaltXBWKwOS1IzM7YWK/bTzRKy9YbUd3XEVwH8dHt9Uwkh24qBlgkrsQhoi+JhhIRN3bu2+OVz1mkPoctcIyNEq8ujFhsSNsD1CLtt50FUpMylXaHBmG2hsbowgbsgkLTG6afnyLGSSUUcmR4kLU8va+vRKr607KrTEBgJZVuQKKFw5zAx/ipFv/34ZpA//fATp82QTpgKrYTKGI//m93UW9FHBHBPoKMGrtg6RLia2N3lx/eQMRlGsRgsGLJ9Y6bnvehGLs5dK99z/jZpbZ1GVxsVWHc0t2BT3zL/E6Fx0TMRBFX+0uvhxpS/REQkgOThviMyhQXVUwt7GSxA6XGU5CRJB6F14cZEx2EKdZpGXUJ3QZVawcK7fmzoFEhAsHn11bQsOentTYVcYrQHfgJDIFth0vjpJZW6f1ejvVmb0aZ9gt1CthVBBJM3+Y0yoTQ0W9nNR+M+IpKUE1N5JK2s6Kxt7V0Ed1t45wRhIOwcIR3DG24zXFG+JQEvCl3OwL0idMeAxB/vpqQ/O8yC/MUmuSbMVtM302jU+rjrXS8343Qvhbm0L/0AjjKOB94zbHKe3GyALZFYp1tbjoRAsi8pz1VMvGEEZ9WcfzWOzi4AFZ8/xpEW49N87Tqyw+Afel33A99deen8HUK89UgEhC3zj7AEVrS1wx/xLle7ZsOGkPelgJp0WBEXaKxBHZgZj4C+QtTgCF/+Ke8gSUcQDhw4P0BTHP8+tjZVAMZHkG30Z0xsNZXnYtLVEp367Bs/B92OLMeA5NpCPo56Hrcl+Ycfezm44Ya6KlPBVuS0bz0tNdxJUTYOj1IeTIEZrEnrklJYTU71hdwcKZqu2sNa98cE9gjvnsDv1VebziS69Ti78yzen1vnNZ36v8JRwTQzDUWIrqtbbInLHPWxkvl/ARu+ypOS1sbjaaBftj7/mozpD1EcGtKdn0bSlVqkSls0aC/E0f4Bd419Dg0cM8rL41TG4veXUch6XrDx9/F3PXR4Qt8umWPFaqQJFE70zI0T/euedM8zmaS0Yxru/hWLVkFF8XEpzwP8hTNbatvYso6yCOhEz9O2mCfAqeLKhbAGzRPtgZBG0p3/eLWndzjQhROSPuoLVwENBuBA82nosgh4jDi9AMoXwvWhWe/O/zjU6CazuASVZEon/EW/IFjSqzf/uJnDK7Qni5ZUqx+gHrdBTAm6XrHeqn8VfTV4I/E0C8iEqlsI5T+YjMnu07oAE6pWCJ0VpV4MqXCJrFaz3yZH+QQfhkszGZMxDdzJ3gZWvecfhpaow2sdeiwmUfIHQStP5tiC7kvo4AaFs1vYo7lRmHdFzAtnanSS64UhvXyT8bKe3PVBRX5St0U1O+JBrhBhG+33Kjudv/rmw8Ichdp93u3IHo9cQb8w68a/fvdzMOtiRWW9/YNSbblKodJk3UQzjHc3DhqCygRpx5r1jG0xxG4oyZTXIapmpuJrdOKaZ12kl9fU6EfgWiqK+rg4JCnqWZWYbiMFdnFvzRXOMqCxUNmAqOiocB5OmabS5aI5ga8V1H8E3RMV8cjeZqVRpYDrRsoQ9kKoC9gdsF5Q90jwZs+Kn7RShMzjEIEgmvfm5E0NYXZjB5nWMIM+kGgu006pymlam7yJZS39Cu+y4mqY+zcepbVmRe8WvORUZ2kGcMQqRn+ZEZ/E3Nx5ReMNXpd295d917KX2StiJNYQHxvwXX7fFDLdQuDcrhtem6v9vnVzqnnUzHLjXqlAH6JAATy7EizfYf1FHLAo7e40hrKKgqUz55ZY4+GHkjiWB9K/QvFFpNyXKL8YFij6QpF//rq5Vt0YzKgFiqhfmA7g5/Vcmxv8EHpS+OFkLwQS7SA9QtPdUX0xW9Ap4q+ii6n0bUYcoP93hkTkObSmnDZbe74bUI1QLuMTVrWkIVAHklGmWD80yuJUaGnBYEif9+EzcGWmFDQLBbe1jIzuT/FC/kgiorhjPd0YaTd6mEPYsQcz39P61gp4qr/9FZhh0XEdn7D3JHFfrtIX5fbnFA2woDofRB4gw5hScXThVTXiyUi9QkQ9jU5yvoXBLC2FuvwEjauRTqZwqjrM3FhBpxIF9AtRZphmec88bS/+C1BkfaJjQkgIjObw7ALNoUZksekrQqaXtdIJIw4DOKi9VzJlM21IpSpc6K/LZSVfZatnLDw76x1fT/aVPWhEoF9WrpMErY3goQ30isGQjkuL+A/x+NFCfct7c2bxANB+FgnxXasThM63CRhKYWYFSHmi9OmyGiVgu7FP6FiVA1enBOPhUNkEzHlVvAnzRAe0oVZphLOQuKLwukn/9K6G1Ek7FiuwpgylmJGlMmKOHtBU8EVd6i3zv3HhsoiiC0SY8rZeUGS89ZuCyQqnBk99H5eqBMAou7XOiNlO/bnR7HOQuGqYCJkjAZ9L2Lb3uxthsoD5h3DMm7dmFhonnGmzsug588Nu43cdi7b7OFxK3HD0/WaPqHfYBsfmAoZwIbUxR6YgoDwbvAbjCKnJnzO7xglI9iN+O5k1CR0+gVhCYRPUotzRILvgg1Tjw+aTwPNgOjKtWB5V1Q99BzL+H7NM+r34ZjhyUxiX4UMrVJQ+U+ysYaxBbhtr0Teq3tETgbxVKqJshH54aInB8I1Wpa4GZlgu26dnsRm8nebJ+C5GFXqOfWRk0HHyGG7hmI94g0a2n2LQrhXXEYM85JvceDSn6+2pJfGwV3wMybGGPRHjllfeHQ7nhGdo3XNTnPWZSxquKfRZInD7+rK3J8xym++RKykXbK4s0+EBAL+G8uFuJ1egaFMQAwzr3HoDYwcKgfBukj6pdNceOp9QkLBev65vIsdr8f1QuHqWG485zt/ysdYr4B2GyiN3kXx8WcO/k49Lakzxu+Wbq7CemHOTLrmCKG0CzjfrlaoRrHkei3CMKffbLAybSbvMEdgW1wbCTScCDWYP8SxSnYZJlG9ytyOIjMB2X9vNqISRSVzmVTLrtUci1z6LIdyRxYPzl5Ny7Ux/5voo68tozn/3UQoKRiZTL1G/IjIYZ9L4ORyVnMXsXxrk+lfs+XGcjJGsNS6OcFUZiK8oEuqcn1gairxDzi2+qjto5tBkcoLxNGUMUJvQ0A+/PjxNuAr040Ae5vQnebCB2HyzLRDvdgaA+8dQ21MHi8TTa3TbZt0IqDNjpJrkS94S6E01KCoVfD9eE1DVg9ZwuEA7a2a/bjG6fLiUNZOn0qXQUWDhgPYPkaFIrVf+9vEI8f/3ePQT208oycMeaGc+GwuA69kQxVXu1NqHadTY7DQZl9B8QDLtuR38oe+o4QRU1YLJvMdrYA0TqrwUTEdvEIoPItZPKmJ628lRE9MPdNCFiSm8CR1cVGG9HmV9DCADfh9vGWWYhshYCxI3RfDU4acy2QZOJtaub/dS22mBq67ccDAGEQ3dJAM5amnkJAdO51+7giwjKHC9PoF91O/yUO66xQrpqbFfICLp6L5rNg5YJBo0DXCyugUui3O+tFxJctCACwjjOjnUe10CLWU0ge/psA5rPAPjXTaGk0smWfmXS+Z82UyTWPkanfVv19/bbbDOnLiQRwBlkom96jXEVue8Wo0g5OILzAKztw5HRsgznE6VIZ8X4o+im9z68CNvlITuvg8MMhih5QddaKe614k93wcWaGMgRxE0slVZhwhki3qgzGdQXNefGRncLxunASvRq4h1MwpfqFSSKXSZ2gUzkJjkWo1cVclwOvmN8TYZDy9sE2CDB/vd4uAdNONXWsbjjcC+S0TteAPbqTPj+a5mR/Qgv9+zznGNAi72RVscZeIjx9uHPKRfuu9xxRjKfIQR1R2fKLsB7jSXD6a7s6clKK0DHDzIAXOdEpilqNZy1z321CGLaqNJ6eO6LCYzKixmbsZ86NoV2igDJV+m0aXyxP6G46K0LUQ6njnq7TSnEhDKXZLwusKuzKOzYzAG0Ut9dxiehiOnSX8ANcEu+ia0Vj4XIKfVkDKOE8Eb1J6SjbxvP8mSBu+307BVZUtw1PrqSPE+RiMngv9wiDqIlqKzVXG2avlMnINuZyAW806wmVd+QpjcPeTAqyVTWj+9nkC8yW4ZJxfK+FaRS4fLyMmuQyo2TtYI1lYeoskaN7HclXdiRJi4axIPXSUzhV+fOX1KtEuiK/0lBsr3nouc9+88Y/XSRDd5zIVarRc9HwmQ1HOCicTr23lPVfjXVr9t36dQW31VVi8X7VvYzSzWCbyoHafqedw+H1jeTfh0kAX/s4ga/XUN7/V8MoTCNyA+oLuGKmfFr+eXkO3R6VMw0v5sWyukAe1l5+/hjffyjrnCGnyjNT2fiEo9w8F/hbSGhr5LDqdvtCwZzVAt7WUvuHJTqzaiZY4VgaVMLti3urW7wcpvx/t+Uy9omB6fUBM5rsYMQvxjuSKeQ5beM+towggVyBgkqhkiG9w0BBwGgggVjBIIFXzCCBVswggVXBgsqhkiG9w0BDAoBAqCCBO4wggTqMBwGCiqGSIb3DQEMAQMwDgQIGGkNx2Oeko8CAggABIIEyJb7s0PqiLdGqIsBNh4GeEon3ggFi/7rnNy8zxbPNj4t7JY1ssT0lQYQRetD2wPIMZ5/sO4hUJJv76Lexkzljmq1iHWdPAOf+p3hmseA0pTVvUqmAawpZ5evnIcBB0A8QROzTctdo6HlFdJXqJSLF1lplfvcLOfcn1XR97MjfKTD0eligGemtIJhKyTeZMGwnQwivweqFNPJm9011ywyMB+W5CYdyni8/L0FtMgW90q4VHJybwu9hCcyW7pkVsFhSEfRLd+XZ1pmfpJYvsEenR5I5RXlRGvGqsNrpacHNL7afUgwNSCePeEHRpCnVpx6xlSY2aoHYMb5By0bG/J3PVpFMF3gH6N9nNii4dEsm+pMWUduUehC0KGjnbRPYvb04aSlDVUnemRL0gX1B+tGxYCZNTFJzeTMYEDS2ZotjbKEIyqQPz7C/jafycoJ7XHgcWs1sFtQCdPa9pHWonTNIfNeMYvFf+tUAPT/p2pF/6RLv39lsL0h2kWBTDcv4bVQRqlhD/pli0aeYpmTsRgpJqyyVV4EZ1GETVBLHsqd8AXSTTEGQSyno6zsRa9wY2HogOEuUstpYeP6QJvELI2lgHkXpHHURNS2nD+4UcoPq8okzpN6i/o0xGf/l6xFjR+Lam+Hb2do+9ZF34P9OABKkXYHVy5cpcBufNyiRjRaAloEfOpP1FMtaTi6yGs6nlD2033rTe6QPBs2E+cHljHgQj6Nuz7ibOFg9RZxRCDBRkeoyIO5wRIqyQtb+W7UWvFbbzf+r5hvZl33DTWwI1vjgZm/8k+SkxNUZVyto4mEUzzIWiQ99Uv+Xta0auXCI6M1PfO9vnA6otdXXa1FfwHK35UKv35rTybsQKNVWafLZ7pbAW4oCyZcw2/mKhrUMVeBYIWpTx4thT5mHFeHTcKpAQDbkwGjO6D6THIGPUPwHkO4G3zg12o8HObDnpGUN+GaXD0LUHVHW9PAzyrpE16S5Pm+FBrJ9rja+miSJKbpG0s3BIm3OgnU3EVcIFGH2GrLPpJf0zZgG44zMNK7RFUsG+ZbnZ8AD/s7FRJ+eznWHUxeO6rNWWME2pJUwsi/oSxUCNjgzy/8uo0uE1Q70oN1KZTj39UtLarBH6QZl0QaTwprRQyBFI0xYPwXhJpO4goiTp3ck7jgFQ3USJfLkYaQRe809Wk3JHtiWvlekg7OvUioJC/VUBs8+YYBno3Vk/+FMWvg2fpHD2su4uvj6ZL6LOtSGoY7o1Gl5u0jlFtq5quluRvdtOBhv+HwbWHDa3XC4pZLPjoT5Oa1NILKp5dgYacqid+/twDDKRkfctHM2Ss/N++ZzXC57rjw9M4nu4sy6NNhpDNDKmGqd9NAh6+zCMzTiD46HYVzv1JmG7ZVbrzpC8lFCeGRy/UohxZcQ14lTnwGBlkfdr7JwNoUd/KXD2E4uDQygvgejvvzZwOdsX0Qu8T6FOmFjC5RXu7dTJQrtkMf5yY1ZubyTiiM2UF/kcC0LHHWEdOcesPm1P3Vh0jsw0h9f4zF/Afzdmr5kjhtM+YnPcfCLnOjyzQi/Ox6cxilKDxVrefFpmtX9iVOcLoR+iRLIvZ4lhzDL7iGY48uxfFKnhuoa1aVuQ5hF+l+VS4tsZJAyOwaUzFWMCMGCSqGSIb3DQEJFTEWBBTVMd8vKw0xUose/7vRtEcH3npqnTAvBgkqhkiG9w0BCRQxIh4gACAAVABFAEMATgBPAFcARQBCAFMAIABTAC4AQQAuAFMwMTAhMAkGBSsOAwIaBQAEFKJxDJMJwfSoBD7pIolFI5rRcnJmBAghQKYFm2+inQICCAA=";

    $url = 'https://backend.estrateg.com/nexusIt/public/api/ubl2.1/config/certificate';
    $metodo = 'PUT'; 
    $datos = $payload;
    $autorizacion = '5de658704d41e7f34cdb752ed5d3379301b9fabcc7604b894904b3953b1bfeec';

    $result = llamarApi($url,$metodo,$datos,$autorizacion);

    //echo $result;
    //echo $certificado;

    $data =  json_decode($result,true);

    if( isset($data["success"])){
        echo $data["message"];
    }else{
        echo "Dato con errores favor verificar";
    }
}
*/