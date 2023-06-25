import React, {useRef,useEffect, useState } from 'react';
import { Button, Form, Input, Table, Divider, Tag,  Breadcrumb, Layout, Menu, theme} from 'antd';

const { Header, Content, Footer } = Layout;
const columns = [
    {
        title: 'name',
        dataIndex: 'name',
        key: 'name',
        render: text => <a href="javascript:;">{text}</a>,
    },
    {
        title: 'Google rank',
        dataIndex: 'google_rank',
        key: 'google_rank',
    },
    {
        title: 'Google search',
        dataIndex: 'google_searches',
        key: 'google_searches',
    },
    {
        title: 'Yahoo rank',
        dataIndex: 'yahoo_rank',
        key: 'yahoo_rank',
    },
    {
        title: 'Yahoo search',
        dataIndex: 'yahoo_searches',
        key: 'yahoo_searches',
    },

];


const Index = () => {


    const [data, setData] = useState([]);
    const ref = useRef(null);

    const handleSubmit = (e) => {
        e.preventDefault();
        const website = document.getElementById('website').value.toLowerCase();
        const keyword = document.getElementById('keyword').value.toLowerCase();
        // console.log(keyword);

        async function fetchData() {
            const response = await fetch(
                `http://127.0.0.1:8000/api/keyword?keyword=${keyword}&website=${website}&token=__lkajsdfaiufekfjb`
            );

            const data = await response.json();
            setData(data);
        }
        fetchData();
    };

    return (
        <Layout className="layout">
            <Header style={{ display: 'flex', alignItems: 'center' }}>
                <div className="demo-logo" />
                <Menu
                    theme="dark"
                    mode="horizontal"
                    defaultSelectedKeys={['2']}
                    items={new Array(1).fill(null).map((_, index) => {
                        const key = index + 1;
                        return {
                            key,
                            label: `Project Check Rank SEO Google & Yahoo`,
                        };
                    })}
                />
            </Header>
            <Content style={{ padding: '0 50px' }}>
                <form onSubmit={handleSubmit}>
                    <Form.Item label="URL" name="website" rules={[{ required: true }]}>
                        <Input id={'website'}/>
                    </Form.Item>

                    <Form.Item label="Keywords" name="keyword" rules={[{ required: true }]}>
                        <Input.TextArea id={'keyword'}/>
                    </Form.Item>

                    <button type="submit">Submit</button>
                </form>
                <Table columns={columns} dataSource={data} scroll={{x: 768}} />
            </Content>
            <Footer style={{ textAlign: 'center' }}>Copyright © 2023 <a href={`https://creand.net`}></a>Creand</Footer>
        </Layout>
    )
}

export default Index
