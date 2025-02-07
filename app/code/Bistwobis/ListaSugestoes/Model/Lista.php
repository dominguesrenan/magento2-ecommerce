<?php
namespace Bistwobis\ListaSugestoes\Model;

use Magento\Framework\Model\AbstractModel;
use Bistwobis\ListaSugestoes\Api\Data\ListaInterface;

class Lista extends AbstractModel implements ListaInterface
{
    /**
     * Constants for keys of data array
     */
    const ENTITY_ID = 'entity_id';
    const TITLE = 'titulo';
    const TIPO_CLIENTE = 'tipo_cliente';
    const DESCRIPTION = 'description';
    const CUSTOMER_GROUPS = 'customer_groups';
    const PRODUTOS = 'produtos';
    const CREATED_AT = 'created_at';

    protected $_idFieldName = 'lista_id';
    
    protected $_eventPrefix = 'bistwobis_lista_sugestoes';
    
    protected $_eventObject = 'lista';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Bistwobis\ListaSugestoes\Model\ResourceModel\Lista::class);
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * Get título
     *
     * @return string|null
     */
    public function getTitulo()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Set título
     *
     * @param string $titulo
     * @return $this
     */
    public function setTitulo($titulo)
    {
        return $this->setData(self::TITLE, $titulo);
    }

    /**
     * Get tipo cliente
     *
     * @return string|null
     */
    public function getTipoCliente()
    {
        return $this->getData(self::TIPO_CLIENTE);
    }

    /**
     * Set tipo cliente
     *
     * @param string $tipoCliente
     * @return $this
     */
    public function setTipoCliente($tipoCliente)
    {
        return $this->setData(self::TIPO_CLIENTE, $tipoCliente);
    }

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set created at
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritDoc
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }
}
