<div class="all-sort-list">
    <?php  foreach ($tree as $category){ ?>
        <div class="item">
            <h3><span>·</span><a href=""><a href="<?=$url?>?category=<?=$category['id']?>"><?=$category['title']?></a></h3>
            <div class="item-list clearfix">
                <div class="close">x</div>
                <?php  if(isset($category['children'])) foreach ($category['children'] as $son){ ?>
                    <div class="subitem">
                        <dl class="fore1">
                            <dt><a href="<?=$url?>?category=<?=$son['id']?>"><?=$son['title']?></a></dt>
                            <dd>
                                <?php  if(isset($son['children'])) foreach ($son['children'] as $grandson){ ?>
                                    <em><a href="<?=$url?>?category=<?=$grandson['id']?>"><?=$grandson['title']?></a></em>
                                <?php }?>
                            </dd>
                        </dl>
                    </div>
                <?php }?>
                <div class="cat-right">
                    <dl class="categorys-promotions" clstag="homepage">
                        <dd>
                            <ul>
                                <li><a href="#"><img src="/images/default.jpg" width="194" height="70" style="margin-bottom: 10px;" ></a></li>
                                <li><a href="#"><img src="/images/default.jpg" width="194" height="70" ></a></li>
                            </ul>
                        </dd>
                    </dl>
                    <dl class="categorys-brands" clstag="homepage">
                        <dt>推荐</dt>
                        <dd>
                            <ul>
                                <li><a href="/index/book">移动开发</a></li>
                                <li><a href="/index/book">嵌入式开发</a></li>
                                <li><a href="/index/book">人工智能</a></li>
                                <li><a href="/index/book">大数据</a></li>
                            </ul>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    <?php }?>
</div>