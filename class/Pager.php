<?php
/*
    pagination 
    @author: shewuling
*/
class Pager
{
	//生成的页码（事实上不用也行）
	private  $pageNumber = '';
	//需要分类的条目总数
	private $totalItems = 0;
	//数据连接相关
	//   private $conn;
	private $num;
	//每页显示几个条目
	private $itemsPerPage = 3;
	//总页数
	private $totalPageNumber = 0;
	//当前页码！
	private $currentPageNumber = 1;
	//一个页面显示几个页码
	private $length = 10;
	//需要分页的url
	private $url = '';
    //分页的名字,默认为 page
    private $page = '';


	public function __construct($num, $currentPageNumber, $itemsPerPage, $length, $url, $page='page')
    {
		$this->totalItems = $num;
		$this->currentPageNumber=$currentPageNumber;
		$this->itemsPerPage=$itemsPerPage;
		$this->length=$length;
		$this->url=$url;
		$this->url.=(stristr($this->url,'?')!=false)?'&':'?';  //Url里有"?"就加"&"没有就加"?"
		$this->getTotalPageNumber();
        //可以实现同一页面多个分页
        $this->page = $page;
	}


	//取得纪录数
	public function getTotalItems()
    {
		return $this->totalItems;
	}


	//取得页数
	public function getTotalPageNumber()
    {
		$this->totalPageNumber=ceil($this->getTotalItems()/$this->itemsPerPage);
		return $this->totalPageNumber;
	}


	//SQL里 LIMIT start，length 中的起始值
	public function getLimitStart()
    {
		$start=($this->currentPageNumber-1)*$this->itemsPerPage;
		return $start;
	}

	//SQL里 LIMIT start，length 中的length
	public function getLimitItems()
    {
		return $this->itemsPerPage;
	}


	/*
	//主函数.中文分页
	public  function getPageNumber(){
		if ($this->getTotalPageNumber()>1){
			//$pageNumber="共 {$this->totalItems} 条记录 ".'当前第'.$this->currentPageNumber.'页/共'.$this->totalPageNumber.'页';
			//显示第一页和前一页
			if ($this->currentPageNumber>1){
				//第一页
				//First Page
				$pageNumber.="<A HREF=".$this->url."page=1>第一页</A>  ";
				//前一页
				//Previous Page
				$pageNumber.="<A HREF=".$this->url."page=".($this->currentPageNumber-1).">前一页</A> ";
			}
			//The start number is the first number of all pages which show on the current page.
			$startNumber=intval($this->currentPageNumber/$this->length)*$this->length;
			//Prev N page
			//交界处
			if ($this->currentPageNumber>=$this->length){
				$pageNumber.="[<A HREF=".$this->url."page=".($startNumber-1).">".($startNumber-1)."</A>]...";
			}
			$leftPageNumber=0;
			for ($i=$startNumber;$i<=$this->totalPageNumber;$i++){
				if ($i==0)continue;
				if ($i-$startNumber<$this->length){
					if ($i==$this->currentPageNumber){
						$pageNumber.="[$i]";
					}else{
						$pageNumber.="[<A HREF=".$this->url."page=".$i.">".$i."</A>]";
					}
				}else{
					$leftPageNumber=$this->totalPageNumber-$i+1;
					break;
				}
			}
			//显示下一个分页列表
			if ($leftPageNumber>=1){
				$pageNumber.="...[<A HREF=".$this->url."page=".($startNumber+
							$this->length).">".($startNumber+$this->length)."</A>] ";
			}
			if ($this->currentPageNumber!=$this->totalPageNumber){
				//Next page
				$pageNumber.="<A HREF=".$this->url."page=".($this->currentPageNumber+1).">下一页</A> ";
				//Last page
				$pageNumber.="<A HREF=".$this->url."page=".$this->totalPageNumber.">最后页</A> ";
			}
			$this->pageNumber=$pageNumber;
			return $this->pageNumber;
		}
	}
	*/
    public  function getPageNumber()
    {
        if ($this->getTotalPageNumber()>1)
        {
            //$pageNumber="共 {$this->totalItems} 条记录 ".'当前第'.$this->currentPageNumber.'页/共'.$this->totalPageNumber.'页';
            //显示First和previous  
            if ($this->currentPageNumber>1)
            {
                //First
                //First Page
                $pageNumber.="<A HREF=".$this->url.$this->page."=1>First</A>  ";
                //previous  
                //Previous Page
                $pageNumber.="<A HREF=".$this->url.$this->page.'='.($this->currentPageNumber-1).">previous  </A> ";
            }
            //The start number is the first number of all pages which show on the current page.
            $startNumber=intval($this->currentPageNumber/$this->length)*$this->length;
            //Prev N page
            //交界处
            if ($this->currentPageNumber>=$this->length)
            {
                $pageNumber.="[<A HREF=".$this->url.$this->page.'='.($startNumber-1).">".($startNumber-1)."</A>]...";
            }
            $leftPageNumber=0;
            for ($i=$startNumber;$i<=$this->totalPageNumber;$i++)
            {
                if ($i==0)continue;
                if ($i-$startNumber<$this->length)
                {
                    if ($i==$this->currentPageNumber)
                    {
                        $pageNumber.="[$i]";
                    }else
                    {
                        $pageNumber.="[<A HREF=".$this->url.$this->page.'='.$i.">".$i."</A>]";
                    }
                }else
                {
                  $leftPageNumber=$this->totalPageNumber-$i+1;
                    break;
                }
            }
            //显示下一个分页列表
            if ($leftPageNumber>=1)
            {
                $pageNumber.="...[<A HREF=".$this->url.$this->page.'='.($startNumber+
                            $this->length).">".($startNumber+$this->length)."</A>] ";
            }
            if ($this->currentPageNumber!=$this->totalPageNumber)
            {
                //Next page
                $pageNumber.="<A HREF=".$this->url.$this->page.'='.($this->currentPageNumber+1).">next</A> ";
                //Last page
                $pageNumber.="<A HREF=".$this->url.$this->page.'='.$this->totalPageNumber.">Last</A> ";
            }
            $this->pageNumber=$pageNumber;
            return $this->pageNumber;
        }
    }
}
$current_page = $_GET['cpage'] + 0;
$page = new Pager(87, $current_page, 5, 5, $_SEREVER['REQUEST_URI'], 'cpage');
echo $page->getPageNumber();
?> 