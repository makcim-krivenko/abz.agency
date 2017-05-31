@extends('layouts.app')

@section('content')
    <div id="tree1" data-url="/gettree"></div>

    <script type="text/javascript">
        $('#tree1').tree({
            onCreateLi: function(node, $li) {
                $li.find('.jqtree-element').append(
                        ', position - ' + node.position
                );
            }
        });
    </script>
@endsection

@section('script')
    <script src="bower_components/jqtree/tree.jquery.js"></script>
    <link rel="stylesheet" href="bower_components/jqtree/jqtree.css">
@endsection
