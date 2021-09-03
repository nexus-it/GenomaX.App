create database DBAPPOdontograma;
use DBAPPOdontograma;

create table TOdontograma
(
codigoOdontograma char(15) not null,
codigoPaciente char(15) not null,
estados text not null,
descripcion text not null,
fechaRegistro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
primary key (codigoOdontograma)
);

delimiter $$
create trigger trggInsertTOdontograma before insert on TOdontograma FOR EACH ROW
begin
set @ultimoCodigo=(select max(codigoOdontograma) from TOdontograma);
if @ultimoCodigo is null then
	set @ultimoCodigo="CODIGOXX0000000";
end if;
set @parteTexto=mid(@ultimoCodigo, 1, 8);
set @parteNumerica=mid(@ultimoCodigo, 9, 7)+1;
set @longitudNumero=(select length(@parteNumerica));
set @codigoNumerico=concat(repeat('0', 7-@longitudNumero), @parteNumerica);
set @codigo=concat(@parteTexto, @codigoNumerico);
set NEW.codigoOdontograma=(select @codigo);
end
$$

select * from TOdontograma;

delete from TOdontograma where codigoOdontograma='CODIGOXX0000001';