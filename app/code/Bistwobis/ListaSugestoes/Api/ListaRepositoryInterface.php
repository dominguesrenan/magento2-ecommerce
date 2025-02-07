<?php
namespace Bistwobis\ListaSugestoes\Api;

interface ListaRepositoryInterface
{
    /**
     * Get list of listas
     *
     * @return \Bistwobis\ListaSugestoes\Api\Data\ListaInterface[]
     */
    public function getList();

    /**
     * Get lista by ID
     *
     * @param int $listaId
     * @return \Bistwobis\ListaSugestoes\Api\Data\ListaInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($listaId);

    /**
     * @param \Bistwobis\ListaSugestoes\Api\Data\ListaInterface $lista
     * @return \Bistwobis\ListaSugestoes\Api\Data\ListaInterface
     */
    public function save(\Bistwobis\ListaSugestoes\Api\Data\ListaInterface $lista);

    /**
     * @param \Bistwobis\ListaSugestoes\Api\Data\ListaInterface $lista
     * @return bool
     */
    public function delete(\Bistwobis\ListaSugestoes\Api\Data\ListaInterface $lista);

    /**
     * @param string $tipoCliente
     * @return \Bistwobis\ListaSugestoes\Api\Data\ListaInterface[]
     */
    public function getByTipoCliente($tipoCliente);
} 