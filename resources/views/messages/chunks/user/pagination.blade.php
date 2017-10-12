<ul class="pagination">
    @if($currentPage == 1)
        <li class="disabled"><span>«</span></li>
    @else
        <li><a href="?p=1">«</a></li>
    @endif
    <?php for($i = 1; $i < ($countPage + 1); $i++): ?>
    <li
            @if($currentPage == $i)
            class="active"
            @endif
    ><a href="?p=<?php echo $i ?>"
        ><?php echo $i ?></a></li>
    <?php endfor; ?>
    @if($currentPage == $countPage)
        <li class="disabled"><span>»</span></li>
    @else
        <li><a href="?p=<?php echo $countPage ?>" rel="next">»</a></li>
    @endif
</ul>
