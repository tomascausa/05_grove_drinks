<?php

/**
 * @author theodor-flavian hanu
 * Date: 9 Mar 2016
 * Time: 16:38
 */
class Artemis_SWP_WP_Parser {

    public function parseString( $input ) {
        $json = json_decode( $input, true );
        if ( ! $json ) {
            return new WP_Error( 'ARTEMIS_SWP_json_error', esc_html__( 'There was an error when reading this JSON file', 'artemis-swp' ), json_last_error_msg() );

        }

        return $this->_doParse( $json );
    }

    function parse( $file ) {

        require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php' );
        require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php' );
        $filesystem = new WP_Filesystem_Direct( array() );

        $json = $filesystem->get_contents( $file );
        $json = json_decode( $json, true );

        return $this->_doParse( $json );
    }

    private function _doParse( $json ) {
        $authors = $posts = $categories = $tags = $terms = array();
        // halt if loading produces an error
        if ( ! $json ) {
            return new WP_Error( 'ARTEMIS_SWP_json_error', esc_html__( 'There was an error when reading this JSON file', 'artemis-swp' ), json_last_error_msg() );

        }

        $json_version = isset( $json['version'] ) ? $json['version'] : null;
        if ( ! $json_version ) {
            return new WP_Error( 'ARTEMIS_SWP_json_error', esc_html__( 'This does not appear to be a ARTEMIS JSON file, missing/invalid version number', 'artemis-swp' ) );
        }
        $base_url = isset( $json['base_site_url'] ) ? $json['base_site_url'] : '';

        // grab authors
        $authors_list = isset( $json['authors'] ) ? $json['authors'] : array();
        foreach ( $authors_list as $author ) {
            $login             = $author['author_login'];
            $authors[ $login ] = array(
                'author_id'           => intval( $author['author_id'] ),
                'author_login'        => $login,
                'author_email'        => (string) $author['author_email'],
                'author_display_name' => (string) $author['author_display_name'],
                'author_first_name'   => (string) $author['author_first_name'],
                'author_last_name'    => (string) $author['author_last_name']
            );
        }
        $category_list = isset( $json['category'] ) ? $json['category'] : array();
        // grab cats, tags and terms
        foreach ( $category_list as $category ) {
            $categories[] = array(
                'term_id'              => intval( $category['term_id'] ),
                'category_nicename'    => (string) $category['category_nice_name'],
                'category_parent'      => (string) $category['category_parent'],
                'cat_name'             => (string) ( isset( $category['cat_name'] ) ? $category['cat_name'] : '' ),
                'category_description' => (string) ( isset( $category['category_description'] ) ? $category['category_description'] : '' )
            );
        }

        $tag_list = isset( $json['tag'] ) ? $json['tag'] : array();
        foreach ( $tag_list as $tag ) {
            $tags[] = array(
                'term_id'         => intval( $tag['term_id'] ),
                'tag_slug'        => (string) $tag['tag_slug'],
                'tag_name'        => (string) ( isset( $tag['tag_name'] ) ? $tag['tag_name'] : '' ),
                'tag_description' => (string) ( isset( $tag['tag_description'] ) ? $tag['tag_description'] : '' )
            );
        }

        $term_list = isset( $json['term'] ) ? $json['term'] : array();
        foreach ( $term_list as $term ) {
            $terms[] = array(
                'term_id'          => intval( $term['term_id'] ),
                'term_taxonomy'    => (string) $term['term_taxonomy'],
                'slug'             => (string) $term['term_slug'],
                'term_parent'      => (string) ( isset( $term['term_parent'] ) ? $term['term_parent'] : '' ),
                'term_name'        => (string) ( isset( $term['term_name'] ) ? $term['term_name'] : '' ),
                'term_description' => (string) ( isset( $term['term_description'] ) ? $term['term_description'] : '' )
            );
        }

        // grab posts

        $post_list = isset( $json['item'] ) ? $json['item'] : array();
        foreach ( $post_list as $item ) {
            $post = array(
                'post_title' => (string) $item['title'],
                'guid'       => (string) $item['guid'],
            );

            $post['post_author']    = (string) $item['creator'];
            $post['post_content']   = (string) $item['content'];
            $post['post_excerpt']   = (string) $item['excerpt'];
            $post['post_id']        = intval( $item['post_id'] );
            $post['post_date']      = (string) $item['post_date'];
            $post['post_date_gmt']  = (string) $item['post_date_gmt'];
            $post['comment_status'] = (string) $item['comment_status'];
            $post['ping_status']    = (string) $item['ping_status'];
            $post['post_name']      = (string) $item['post_name'];
            $post['status']         = (string) $item['status'];
            $post['post_parent']    = intval( $item['post_parent'] );
            $post['menu_order']     = intval( $item['menu_order'] );
            $post['post_type']      = (string) $item['post_type'];
            $post['post_password']  = (string) $item['post_password'];
            $post['is_sticky']      = intval( $item['is_sticky'] );

            if ( isset( $item['attachment_url'] ) ) {
                $post['attachment_url'] = (string) $item['attachment_url'];
            }

            if ( isset( $item['category'] ) && is_array( $item['category'] ) ) {
                foreach ( $item['category'] as $c ) {
                    $post['terms'][] = array(
                        'name'   => (string) $c['name'],
                        'slug'   => (string) $c['nicename'],
                        'domain' => (string) $c['domain']
                    );
                }
            }
            if ( isset( $item['postmeta'] ) && is_array( $item['postmeta'] ) ) {
                foreach ( $item['postmeta'] as $meta ) {
                    $post['postmeta'][] = array(
                        'key'   => (string) $meta['meta_key'],
                        'value' => (string) $meta['meta_value']
                    );
                }
            }
            if ( isset( $item['comment'] ) && is_array( $item['comment'] ) ) {

                foreach ( $item['comment'] as $comment ) {
                    $meta = array();
                    if ( isset( $comment['commentmeta'] ) ) {
                        foreach ( $comment['commentmeta'] as $m ) {
                            $meta[] = array(
                                'key'   => (string) $m['meta_key'],
                                'value' => (string) $m['meta_value']
                            );
                        }
                    }

                    $post['comments'][] = array(
                        'comment_id'           => (int) $comment['comment_id'],
                        'comment_author'       => (string) $comment['author'],
                        'comment_author_email' => (string) $comment['comment_author_email'],
                        'comment_author_IP'    => (string) $comment['comment_author_IP'],
                        'comment_author_url'   => (string) $comment['comment_author_url'],
                        'comment_date'         => (string) $comment['comment_date'],
                        'comment_date_gmt'     => (string) $comment['comment_date_gmt'],
                        'comment_content'      => (string) $comment['comment_content'],
                        'comment_approved'     => (string) $comment['comment_approved'],
                        'comment_type'         => (string) $comment['comment_type'],
                        'comment_parent'       => (string) $comment['comment_parent'],
                        'comment_user_id'      => (int) $comment['comment_user_id'],
                        'commentmeta'          => $meta,
                    );
                }
            }

            $posts[] = $post;
        }

        return array(
            'authors'    => $authors,
            'posts'      => $posts,
            'categories' => $categories,
            'tags'       => $tags,
            'terms'      => $terms,
            'base_url'   => $base_url,
            'version'    => $json_version
        );
    }
}
