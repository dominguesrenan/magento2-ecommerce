<?php
namespace Bistwobis\ListaSugestoes\Api\Data;

interface ListaInterface
{
    const LISTA_ID = 'lista_id';
    const TITULO = 'titulo';
    const TIPO_CLIENTE = 'tipo_cliente';
    const CREATED_AT = 'created_at';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string|null
     */
    public function getTitulo();

    /**
     * @param string $titulo
     * @return $this
     */
    public function setTitulo($titulo);

    /**
     * @return string|null
     */
    public function getTipoCliente();

    /**
     * @param string $tipoCliente
     * @return $this
     */
    public function setTipoCliente($tipoCliente);

    /**
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);
}
